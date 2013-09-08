---
layout: default_ja
title: BEAR.Sunday | アスペクト指向プログラミング
category: DI＆AOP
---
# アスペクト指向プログラミング (AOP)

BEAR.Sundayの[アスペクト指向プログラミング(AOP)](http://ja.wikipedia.org/wiki/%E3%82%A2%E3%82%B9%E3%83%9A%E3%82%AF%E3%83%88%E6%8C%87%E5%90%91%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0) で、例えば「*@Log* とアノテートされたメソッドはその結果を必ず記録する」ということが*対象のメソッドや呼び出し元を変更する事なし*に可能になります。

AOPはクラスの直接的な責務ではない、各モジュールから共通で使われる処理を、独立して切り出す手法です。多くのクラスに重複コードが生まれてしまうような処理は、アスペクト(横断的関心事) として[関心を分離](http://ja.wikipedia.org/wiki/%E9%96%A2%E5%BF%83%E3%81%AE%E5%88%86%E9%9B%A2)し別のモジュールにしてしまうという手法をとることが出来ます。


BEAR.Sundayではフレームワークの様々な機能をアスペクトの集合と考え横断的な機能をAOPで実装しています。[injector インジェクター]はオブジェクトを生成する際にモジュールに従い特定の条件の適合するメソッドにアスペクトを織りみます。アスペクトはインターセプターとも呼ばれメソッドをコールする側とメソッドの間に割り込むように働きます。アスペクトが織り込まれたメソッドは常に横断的な処理が補完されますが、関心と実装は完全に分離されその束縛は動的です。

BEAR.Sundayで使用しているAOPフレームワークRay.AopはAOPアライアンスの[MethodInterceptorインターフェイス](http://aopalliance.sourceforge.net/doc/org/aopalliance/intercept/MethodInvocation.html#getMethod%28%29)を実装していてGoogle Guice, Spring等のAOPと同様のものです。

## インターセプター 

インターセプターはメソッドの呼び出しに割り込んで、クラスの横断的処理を行います。インターセプターは`invoke`メソッドを実装し、そのメソッド内でオリジナルのメソッドを呼び出す事で横断的処理を実現します。

    public function invoke(MethodInvocation $invocation);

以下は受け取った引数と実行した出力をログに記録するロガーインターセプターです。

    class Logger implements MethodInterceptor
    {
        use LogInject;

        /**
         * (non-PHPdoc)
         * @see Ray\Aop.MethodInterceptor::invoke()
         */
        public function invoke(MethodInvocation $invocation)
        {
            $result = $invocation->proceed();
            $class = get_class($invocation->getThis());
            $args = $invocation->getArguments();
            $input = json_encode($args);
            $output = json_encode($result);
            $log # "target = [{$class}], input = [{$input}], result  [{$output}]";
            $this->log->log($log);
            return $result;
        }
    }

このインターセプターにはインジェクトされたLogオブジェクトを使って、呼び出し引数とその結果をJSON形式でログに記録します。このインターセプターはsandboxアプリケーションではDEVモードでは全てのリソースにバインドされデバックに役立てる事ができるようになっています。

このロガーがバインドされたメソッドには何の変更もありませんがログ機能が追加されました。元のメソッドはロガーの更新、着脱に元のメソッドは無関心です。関心は元のメソッドが本来もつ*本質的関心時 (core concern)* と、ログをとるというメソッドをまたいで適用される*横断的関心事(cross cutting concern)* に分離されています。ロガーが使うログオブジェクトもインジェクトされ、ロガーはそのログオブジェクトの実装に依存することなく抽象（インターフェイス）に依存しています。

## マッチャー・バインディング 

作成したインターセプターはメソッドにバインドすることで機能します。どのメソッドにバインドするかに利用するのが*matcher* です。以下はログオブジェクトをインジェクトした`Logger`オブジェクトを`BEAR\Resource\Object`を継承したクラスの'on'で始まる全てのメソッドに束縛します。

    $logger = $this->requestInjection('BEAR\Framework\Interceptor\Logger');
    $this->bindInterceptor(
        $this->matcher->subclassesOf('BEAR\Resource\Object'),
        $this->matcher->startWith('on'),
        [$logger]
    );

`bindInterceptor`は３つのパラメーターをとり、１つめがクラスマッチ、２つ目がメソッドマッチ、３つ目がインターセプターです。

| メソッドシグネチャ |　機能 |
| ------------- | ------------- |
| bool subclassesOf($class) | サブクラスを指定します。第二引数には指定できません。|
| bool any() | どれにもマッチします。|
| bool annotatedWith($annotation) | $annotationはアノテーションのフルパスです。このアノテーションが付いているものにマッチします。 |
| bool startWith($prefix) | この文字列で始まるクラス／メソッドにマッチします。|


例えば以下をメソッドマッチで指定するとsetXXという名前のメソッドにマッチします。

    $this->matcher->startWith('set')

## `MethodInvocation` 
インターセプターはMethodInvocation（メソッド実行）型の変数を受け取り、メソッドの実行の前後に処理を挟んだり、その変数を使って元のメソッドを実行します。`MethodInvocation`の主なメソッドは以下の通りです。

| メソッドシグネチャ |　機能 |
| ------------- | ------------- |
| void proceed() | 対象メソッド実行 |
| Reflectionmethod getMethod() | 対象メソッドリフレクションの取得 |
| Object getThis() | 対象オブジェクトの取得 |
| array getArguments() (| 呼び出し引数配列の取得 |
| array getAnnoattions() | 対象メソッドのアノテーション取得 |

## Ray.Aop 
BEAR.Sundayが利用しているAOPフレームワーク、[Ray.Aop](http://code.google.com/p/rayphp/wiki/AOP)のマニュアルもご覧下さい。