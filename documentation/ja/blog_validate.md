---
layout: default_ja
title: BEAR.Sunday | blogチュートリアル(7) バリデーション
category: ブログ・チュートリアル
---
# blogチュートリアル(7) バリデーション

# フォーム 

前回のセクションで記事追加ページにPOSTインターフェイスが実装され、記事の追加をHTTPメソッドで受ける事ができるようになりました。

次はできあがったPOSTインターフェイスに、バリデーション、フィルター、エラー再入力時のデフォルト値設定などのwebフォームとして機能を加えましょう。

 Note: このチュートリアルでは特別な専用ライブラリを使用しないでプレーンなPHPでコーディングしています。実際にはZend FrameworkやSymfony、あるいはその他のバリデーションライブラリやフォームライブラリーを利用するのがいいでしょう。

## バリデーション 

特定のライブラリに依存しないフォームをインターセプターとして実装してみます。まずは`@Form`アノテーションとフォームバリデーションインターセプターの束縛です。

アノテーション sandbox\Annotation\Form

    namespace Sandbox\Annotation;

    /**
     * Form
     *
     * @Annotation
     * @Target({"METHOD"})
     */
    final class Form
    {
    }

インターセプターの束縛

    /**
     * @Form - bind form validator
     */
    private function installFormValidator()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Sandbox\Resource\Page\Blog\Posts\Newpost'),
       	    $this->matcher->annotatedWith('sandbox\Annotation\Form'),
            [new PostsFormValidator]
        );
    }


これで@Formとアノテートされているメソッドに`PostsFormValidator`が束縛されました。リクエストがPOSTメソッドをコールする前にこのバリデートインターセプターが呼ばれます。

## @Formバリデーションインターセプター 
リクエストとメソッドに割り込んだインターセプターでは、タグを取り除くフィルター処理の後にバリデーションをしています。バリデーションが通れば元のPOSTメソッドを呼びます。

    return $invocation->proceed();

バリデーションNGならエラーメッセージや初期値などをセットし*加工したGETリクエストのページ* を出力します。POSTインターフェイスメソッドは呼ばれません。

    return $page->onGet();

すべてをまとめた`PostsFormValidator`はこのようになります

    /**
     * Log Interceptor
     */
    class PostsFormValidator implements MethodInterceptor
    {
    	const TITLE = 0;
    	const BODY = 1;
	
    	/**
    	 * Error
    	 * 
    	 * @var array
    	 */
    	private $errors = [
    		'title' => '',
    		'body' => ''
    	];
	
        /**
         * (non-PHPdoc)
         * @see Ray\Aop.MethodInterceptor::invoke()
         */
        public function invoke(MethodInvocation $invocation)
        {
            // retrieve page and query
        	$args = $invocation->getArguments();
        	$page = $invocation->getThis();
    	
        	// strip tags
        	foreach ($args as &$arg) {
        		$arg = strip_tags($arg);
        	}
    	
        	// required title
        	if ($args[self::TITLE] # = '') {
        		$this->errors['title'] = 'title required.';
        	}
    	
        	// required body
        	if ($args[self::BODY] # = '') {
        		$this->errors['body'] = 'body required.';
        	}
    	
        	// valid form ?
        	if (implode('', $this->errors) # = '') {
    	    	return $invocation->proceed();
        	}
    	
            // error, modify 'GET' page with error message.
        	$page['errors'] = $this->errors;
        	$page['submit'] =[
        		'title' => $args[self::TITLE],
        		'body' => $args[self::BODY]
        	];
        	return $page->onGet();
        }
    }

[Aopアライアンス](http://aopalliance.sourceforge.net/)準拠の[MethodInterceptor](https://github.com/koriym/Ray.Aop/blob/master/src/Ray/Aop/MethodInterceptor.php)インターフェイスを実装します。invokeに渡される`$invocation`は`MethodInvocation`型の*メソッド実行オブジェクト*です。

`$invocation->getArguments()`でメソッド呼び出し時の引数が、`$invocation->getThis();`で呼び出し元の記事表示ページリソースオブジェクトが得られています。

 Note: 引数は名前付き引数でなく、メソッドコールの時と同じ様に順番で指定され渡ります。