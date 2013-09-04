#summary はじめてのDI

## 挨拶を依存にしてさまざまな挨拶を可能にする 

[my_first_resource はじめてのリソース]の挨拶リソースは"Hello"と英語で固定されていました。ここではDI(Dependency Injection =[依存性の注入](http://ja.wikipedia.org/wiki/%E4%BE%9D%E5%AD%98%E6%80%A7%E3%81%AE%E6%B3%A8%E5%85%A5)）を使ってさまざまな挨拶に多応するリソースにしましょう。

## 依存(dependency) 
[my_first_resource 挨拶リソース]では挨拶するための挨拶文字列が必要です。これがこのリソースの依存（dependency)です。この文字列はどのように用意できるでしょうか？大きく３つの方法があります。

### 1.内包する (dependency inside) 
依存をコード内に記述します。[my_first_resource はじめてのリソース]では"Hello"がメソッド内にハードコードされてました。これをクラス定数constにすればもう少しメンテナンス性や可読性が良くなるでしょう。しかし依存がコード内に存在してるという意味ではハードコードも`const`も同じです。変更にはクラスを変更する必要があります。

### 2.取得する (dependency pull) 
その昔、設定といえばグローバル`define`でした。それがConfigオブジェクトを使うようになりました。どちらも外部から依存を取得することには代わりはありません。これはサービスロケータを使っても同じです。外部から`pull`
しています。

テストをするときには依存（設定ファイルやdefine）を変更する必要があります。

### 3.代入してもらう (dependency injection) 
自ら挨拶文字列を取得するのではなく、コンストラクションの時に外部から挨拶文字列を代入してもらいます。依存の取得に関して利用クラスは完全に受け身です。テストの時にはその依存をコンストラクタや専用のセッターメソッドを使って渡します。

## コンストラクタで受け取る 
[my_first_web_page_2 はじめてのリソースリクエスト]ではtraitをつかった注入を行いましたが、ここではコンストラクタで受け取ってみます。

コンストラクタはこのようなコードになります。
`外部からの代入（注入）が欲しいコンストラクタにに`@Inject`とマークしています。その際この注入を特定するために、注入個所（インジェクトポイント）に`@Named`で名前をつけています。

{{{
    /**
     * Constructor
     * 
     * @param string $message
     * 
     * @Inject
     * @Named("greeting_msg")
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}}}

### まずは注入失敗を実験してみる 

できあがったファイルは`app://self/first/greeting/di`のURIでリクエストできるように保存しました。

注入される箇所のマークは行いましたが、何を注入するかは設定していません。これでは注入を行うインジェクターはうまく注入をすることができません。その失敗を実験してみます。

{{{
$ php api.php get 'app://self/first/greeting/di'
}}}
{{{
500 Internal Server Error
X-EXCEPTION-CLASS: Ray\Di\Exception\NotBound
X-EXCEPTION-MESSAGE: typehint# '', annotate'greeting_msg' for $message in class 'Sandbox\Resource\App\First\Greeting\Di'
X-EXCEPTION-CODE: 0
[BODY]
Internal error occurred (e5f464)
}}}

`Ray\Di\Exception\NotBound`例外が発生しました。

例外メッセージはtypehintなしで`greeting_msg`という名前で束縛されたDI設定が無い事を表してます。

`greeting_msg`という名前で依存性を束縛するDI設定が必要です。

### 注入設定のDSL 

DI設定（注入の設定）はモジュールの`configure`メソッド内で行います。[AppModule](https://github.com/koriym/BEAR.Sunday/blob/master/apps/Sandbox/Module/AppModule.php)の`configure`メソッドのどこでもよいので下記の行を追加します。

{{{
$this->bind()->annotatedWith('greeting_msg')->toInstance('Hola');
}}}

これで`@Inject`とマークし`@Named("greeting_msg")`と名前を指定したメソッド（またはコンストラクタ）に'Hola'が渡ります。

ここでは何かの実体（インスタンス）を直接していますが、クラス名やファクトリークラス名を指定する事もできます。ファクトリーでは複雑なインスタンス生成が可能です。※ 生成方法は変わっても受けとる方の記述は同じです。

{{{
    /**
     * @Inject
     * @Named("greeting_msg")
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}}}
## 確認します 
{{{
$ php api.php get 'app://self/first/greeting/di?name=BEAR'
}}}
{{{
200 OK
...
[BODY]
"Hola, BEAR"
}}}

モジュールで設定したインスタンス（文字列）が注入されています！これで挨拶文字列の用意は利用クラスから切り離されました。挨拶文字列がDBやファイルから用意されるようになっても、利用クラスに変更はありません。準備するモジュールに変更があるだけです。

この利用クラスではDIの利用をするためにアノテーションを使用してますがそれだけです。固有のコンストラクタや特定のメソッド名、特定のオブジェクトコンテナの使用のないごく普通のクリーンなPHPクラスです。依存は手動で渡せばユニットテストも簡単です。

利用クラスのモジュール性は高まり、再利用性とテストが容易になりました。