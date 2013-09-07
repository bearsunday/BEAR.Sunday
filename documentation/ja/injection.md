---
layout: default_ja
title: BEAR.Sunday | インジェクション
category: DI＆AOP
---

# インジェクション

フレームワークが予めバインドしているインターフェイスを変更することによってアプリケーションの振る舞いを変更することができます。またtraitを使ったセッターインジェクションでコードの可読性をたかめ、依存をより簡単に利用することができます。


## バイディング済みインターフェイス 

`FrameworkModule`はBEAR.Sundayフレームワークの基本のバインディングを行っています。アプリケーションはこのバインディングを変更して特定または独自の実装に変更することができます。

例えば例外発生のハンドリングを変更するには`BEAR\Framework\Exception\ExceptionHandlerInterface`に独自に作成した例外ハンドルクラスをバインドします。

|| *インターフェイス* || *バインドされているクラスまたはプロバイダー* || *内容* || 
|| `BEAR\Framework\Exception\ExceptionHandlerInterface` || `BEAR\Framework\Exception\ExceptionHandler` || 例外ハンドル ||
|| `BEAR\Framework\Web\ResponseInterface` || `BEAR\Framework\Web\SymfonyResponse` || HTTP出力 ||
|| `BEAR\Framework\Output\ConsoleInterface` || `BEAR\Framework\Output\Console` || コンソール出力 ||
|| `Doctrine\Common\Annotations\Reader` || `Doctrine\Common\Annotations\AnnotationReader` || アノテーションリーダー ||
|| `BEAR\Resource\LoggerInterface` || `BEAR\Framework\Module\Provider\ResourceLoggerProvider` || リソースロガー ||
|| `BEAR\Framework\Application\LoggerInterface` || `BEAR\Framework\Module\Provider\ResourceLoggerProvider` || アプリケーションロガー ||
|| `Guzzle\Parser\UriTemplate\UriTemplateInterface` || `Guzzle\Parser\UriTemplate\UriTemplate` || URIテンプレート ||
|| `BEAR\Framework\Resource\Taggable` || `BEAR\Framework\Resource\Etag` || キャッシュキー ||
|| `Guzzle\Common\Cache\CacheAdapterInterface` || `BEAR\Framework\Module\Provider\ApcCacheProvider` ||キャッシュアダプター ||

## アプリケーションバインディング 

アプリケーションのモードや方針に応じてバインディングが求められるインターフェイスもあります。たとえばリソースをどのようにレンダリングするか(HTML or JSON ?)や、テンプレートエンジン、キャッシュライブラリ等です。通常`AppModule`が使われます。

|| *インターフェイス* || *バインドされているクラス* || *サービス* ||
|| `BEAR\Resource\Renderable` || `BEAR\Framework\Resource\View\Renderer` || HTML||
|| || `BEAR\Framework\Resource\View\DevRenderer` || Dev用HTML||
||  || `BEAR\Framework\Resource\View\JsonRenderer` || JSON||
||  || `BEAR\Framework\Resource\View\HalRenderer` || JSON+HAL　||
|| `BEAR\Framework\Resource\View\TemplateEngineAdapter` || `BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter` || Smarty ||
|| `Guzzle\Common\Cache\CacheAdapterInterface @Named("resource_cache")` || `BEAR\Framework\Module\Provider\ApcCacheProvider` ||リソースキャッシュ ||

### フレームワークバインドを変更するバインドのタイミング 
`$this->installModule()`とフレームワークモジュールをインストールする前に独自のバインディングを行います。

## トレイトインジェクション 

コードの可読性の向上や簡素化のためセッターメソッドのコードをtraitにすることができます。

トレイト名は`"{プロパティ名}Inject"`とインジェクトされた依存を代入したプロパティに`Inject`を付けてものになります。例えば`TmpDirInject`トレイトを`use`すると`tmpDir`プロパティに`TMPディレクトリ`がインジェクトされます。

例)
    class Foo {
        use TmpDirInject;

        public function onGet()
        {
            $tmpDir = $this->tmpDir;
            ...

## トレイト名前一覧 


|| *トレイト名* || *インジェクトされる依存* ||
|| `TmpDirInject` || Tmpディレクトリ ||
|| `LogDirInject` || Logディレクトリ ||
|| `AppDirInject` || Appディレクトリ ||
|| `LogInject` || [Logオブジェクト](http://guzzlephp.org/api/class-Guzzle.Common.Log.LogAdapterInterface.html) ||
|| `ResourceInject` || [リソースクライアント](http://code.google.com/p/bearsunday/wiki/resource_client) ||