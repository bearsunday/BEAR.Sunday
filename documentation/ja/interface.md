---
layout: default_ja
title: BEAR.Sunday | インターフェイス
category: アプリケーション
---

# インターフェイス

BEAR.Sundayではインターフェイスとクラスの束縛（binding)を変更することでフレームワークの振る舞いを柔軟に構成することができます。

## モジュールの合成  

`BEAR\Sunday\Module\Framework\FrameworkModule`はBEAR.Sundayフレームワークの基本の束縛を行っています。アプリケーションはこのバインディングを変更して特定または独自の実装に変更することができます。

### FrameworkModule
    class FrameworkModule extends AbstractModule
    {
        protected function configure()
        {
            $this->install(new Module\Framework\ConstantModule);
            $this->install(new Module\Log\ApplicationLoggerModule);
            $this->install(new Module\Di\InjectorModule($this->dependencyInjector));
            $this->install(new Module\Code\CachedAnnotationModule);
            $this->install(new Module\Signal\SignalModule);
            $this->install(new Module\Resource\ResourceModule($this->dependencyInjector));
            $this->install(new Module\Output\ConsoleModule);
            $this->install(new Module\Http\GuzzleModule);
            $this->install(new Module\TemplateEngine\ProdRendererModule);
        }
    }

これらのモジュール内ではフレームワークの機能に最小限度必要なデフォルトの束縛が行われています。
このフレームワークモジュールにアプリケーションを横断するパッケージモジュール`BEAR\Package\Module\Package\PackageModule`とアプリケーションモジュール、またコンテキストに応じたモードモジュールが合成されアプリケーション実行に必要な全ての束縛が完了します。

## コンテキストによる束縛 

アプリケーションのコンテキスト（モードや方針）に応じて束縛が求められるインターフェイスもあります。たとえばリソースをどのようにレンダリングするか(HTML or JSON ?)や、テンプレートエンジン、キャッシュライブラリ等です。通常`AppModule`が使われます。

|| *インターフェイス* || *束縛されているクラス* || *サービス* ||
|| `BEAR\Resource\Renderable` || `BEAR\Framework\Resource\View\Renderer` || HTML||
|| || `BEAR\Framework\Resource\View\DevRenderer` || Dev用HTML||
||  || `BEAR\Framework\Resource\View\JsonRenderer` || JSON||
||  || `BEAR\Framework\Resource\View\HalRenderer` || JSON+HAL　||
|| `BEAR\Framework\Resource\View\TemplateEngineAdapter` || `BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter` || Smarty ||
|| `Guzzle\Common\Cache\CacheAdapterInterface @Named("resource_cache")` || `BEAR\Framework\Module\Provider\ApcCacheProvider` ||リソースキャッシュ ||

### モジュールのオーバーライド 

モジュール内で既存のモジュールで束縛されている内容を上書きするにはこのように$thisを渡します。

```
$this->install(new OverRideModule($this));
```


$thisを渡さない`install`は束縛が行われていないインターフェイスにしか束縛が行われません。
```
$this->install(new SomeModule);
```


## トレイト名前一覧 

### 定数 
|| *トレイト名* || *インジェクトされる依存* || namespace ||
|| `TmpDirInject` || Tmpディレクトリ || BEAR\Sunday\Inject ||
|| `LogDirInject` || Logディレクトリ || BEAR\Sunday\Inject ||
|| `AppDirInject` || Appディレクトリ || BEAR\Sunday\Inject ||
|| `AppNameInject` || App名|| BEAR\Sunday\Inject ||

### サービスオブジェクト 
|| `LogInject` || [LOGオブジェクト](http://guzzlephp.org/api/class-Guzzle.Common.Log.LogAdapterInterface.html) || BEAR\Sunday\Inject ||
|| `ResourceInject` || [リソースクライアント](http://code.google.com/p/bearsunday/wiki/resource_client) || BEAR\Sunday\Inject ||