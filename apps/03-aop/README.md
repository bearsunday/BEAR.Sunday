# Framework prototype

## Run
	$ git clone git://github.com/koriym/BEAR.Resource.git
	$ cd BEAR.Resource/
	$ git submodule update --init
	$ chmod -R 777 doc/01-mvc/script/cache/
	$ cd doc/01-mvc/htdocs
	$ php index.php --url Hello
	$ php index.php --url HelloAop

## Result
    Content-Type: text/html; charset=UTF-8
    <html>
    <body>Hello World</body>
    </html>
    
    [Log] target = helloworld\ResourceObject\Greeting\Aop, input = Array, result = Hello World
    Content-Type: text/html; charset=UTF-8
    <html>
    <body>Hello World</body>
    </html>
    
## Function

 * Basic MVC like module.
 * Entire object graph is cached.
 * Parameter provider in Page. (@Provide)
 * Aspect oriented programing. (@Aspect, @Log)
 * View observe controller.
 * Framework / Application separated module.

namespace helloWorld;

## Overview

 * このサンプルはサービスレイヤーフレームワークBEAR.Resourceを使ったWebフレームワークのプロトタイプです。
 * アプリケーションリソース、HTMLビュー、ページリソースがMVCに対応します。
 * ルーターやディスパッチャーなどフロントコントローラー部分等主要部分以外を省略してあります。

### index.php
boostrapスクリプトで３つの変数が用意されます。

 * リソースクライアント $reource 
 * ページリソース $page
 * DIコンテナ $di

URLに応じてこの変数が用意されます。

    include dirname(__DIR__) . '/script/bootstrap.php';

リソースリクエストDSLでページリソースをリクエストしています。

    $response = $resource->get->object($page)->eager->request();

 * $responseはアプリケーションリソースへのリクエスト結果、またはリクエストそのものを含んだページリソースです。
 * ページの主な仕事と責任はアプリケーションリソースへのリクエストです。
 * ページはレンダリングの責任を負いません。Viewも知りません。

Viewスクリプトをincludeします。

    include dirname(__DIR__) . '/View/Hello.php';


### Page/HelloAop.php

 * index.phpでのgetリクエストによりページのonGet()が呼ばれます。
 * greetingリソースをリクエストしてその結果を自らの['greeting']に格納しています。
 * ページは自らがリクエストされた同じDSLを使って他のリソースをリクエストしています。
 * 言語を指定する$langクエリーが付いています。
 * 戻り値として$this(ページ)を返しています。

getリクエストハンドラー

	public function onGet($lang)
	{
		$this['greeting'] = $this->resource
		->getー>object($this->greeting)->withQuery(['lang' => $lang])->eager->request();
    		return $this;
	}

 * それではページが受け取った$langは誰が手渡したのでしょう？（index.phpではクエリーを指定していません。)必要なパラメーターが無い場合は、パラメタープロバイダーがその値を用意します。
 * リソースのクエリーはリクエストが不完全であっても、リソース側が補完する場合があります。
 * @Provide("lang")というアノテーションが、このメソッドが$langプロバイダーになる事を表しています。
 * 情報の取得順の反転が可能になります。

パラメタープロバイダー

	/**
	 * @Provide("lang")
	 */
	public function provideLang()
	{
		return 'en';
		// return $_GET['lang']; or
		// return $this->webContext->getCookie('lang');
	}

### ResourceObject/greeting/aop.php

 * ページリソースからリクエストされたアプリケーションリスースは受け取った$langに従って挨拶を返します。
 * @Logはロギングのためのメソッドインターセプターが適用される事を表します。
 * インターセプターではメソッド実行の前後の処理を定義することができます。

メソッドインターセプターアノテーション(@Log)付のアプリケーションリソース

	/**
	 * @Log
	 */
	public function onGet($lang)
	{
	    $greeting = $this->message[$lang];
	    return $greeting;
	}

### View/Hello.php

 * Viewはクライアントに対するリソース表現です。
 * それぞれのViewからページリソースを見て、レンダリングします。
 * ここでは簡単なHTMLにしています。
 * テンプレートエンジンの利用、RSS、JSON、モバイルアプリ向けXML出力など、Viewの責任です。

View

    foreach ($response->headers as $header) {
        header($header);
    }
    $body = (object)$response->body;
    ?><html><body><?php echo $body->greeting?></body></html>
    
### DIとオブジェクトグラフとそのキャッシュ

 * ページリソース、アプリケーションリソース、ビューと主要コンポーネントをみてきました。
 * それぞれのコードでデータやサービスを取得しているコードが無かったのにお気づきでしょうか？
 * それらはアノテーションや"モジュール"によるバインディングでインスタンス生成時にインジェクトされます。
 * ページリソースをルートとした全てを含むオブジェクトグラフはキャッシュされ、DIやアノテーション利用のコストは最小化されます。
 * DIは[Ray](http://code.google.com/p/rayphp/)を使用しています。RayはGuice/JSR-330のアノテーションベースのDIコンテナです。

### テスタビリティ

 * コンポーネントは独立して動作します。
 * リクエストに状態がありません。
 * リソースリクエストはURL表現できます。

### まとめ

 * ページリソースももアプリケーションリソースも基本的には同じものです。
 * 全てのサービスオブジェクトはオブジェクトグラフが整った状態でキャッシュされます。
 * リクエストでのみ決定される部分だけを動作させようとしています。
 * コントローラーが頑張りません。
 * パラメータープロバイダやDIによって情報取得の反転が可能です。(push, pull request)
 * test-friendlyコンポーネント、performance-friendly DIでありたいと思います。
  
### @todo

 * Viewをリソース化
 * リンク実装
 * ページとViewはリンクで接続
 * ViewとOutputもリンクで接続