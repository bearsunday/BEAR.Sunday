---
layout: default
title: BEAR.Sunday | Interface 
category: Application
---
# Interface

In BEAR.Sunday by changing the interface class bindings you can flexibly configure the frameworks behavior. 

## Module collections  

`BEAR\Sunday\Module\Framework\FrameworkModule` carries out the BEAR.Sunday framework core bindings. By changing the application bindings you can change the particulars and indeed the whole runtime environment.

### Framework Module 
```
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
```

Inside these modules the most basic defaults needed for normal framework functionality are bound.
These framework modules, the package module that makes application decisions `BEAR\Package\Module\Package\PackageModule`, application modules and mode modules according to context are grouped and all bindings needed for the application to run are complete.

## Context Bindings 

There are also interfaces where bindings are looked up depending on the application context. For example how a source is rendered (HTML or JSON ?), template engine used or chosen caching library. Normally `AppModule` is used.

|| *Interface* || *Bound Class* || *Service* ||
|| `BEAR\Resource\Renderable` || `BEAR\Framework\Resource\View\Renderer` || HTML||
||  || `BEAR\Framework\Resource\View\DevRenderer` || Dev用HTML||
||  || `BEAR\Framework\Resource\View\JsonRenderer` || JSON||
||  || `BEAR\Framework\Resource\View\HalRenderer` || JSON+HAL　||
|| `BEAR\Framework\Resource\View\TemplateEngineAdapter` || `BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter` || Smarty ||
|| `Guzzle\Common\Cache\CacheAdapterInterface @Named("resource_cache")` || `BEAR\Framework\Module\Provider\ApcCacheProvider` ||リソースキャッシュ ||

### Overriding Module 

To overwrite the contents of the dependency bound in the module, you pass `$this` like below.

```
$this->install(new OverRideModule($this));
```


If you do not pass `$this` as a parameter, `install` will only be able to make a binding to an interface that has no binding.
```
$this->install(new SomeModule);
```


## Trait Name List 

### Constants 
|| *Trait Name* || *Injected Dependency* || Namespace ||
|| `TmpDirInject` || Tmp Directory || BEAR\Sunday\Inject ||
|| `LogDirInject` || Log Directory || BEAR\Sunday\Inject ||
|| `AppDirInject` || App Directory || BEAR\Sunday\Inject ||
|| `AppNameInject` || App Name || BEAR\Sunday\Inject ||

### Service Object 
|| `LogInject` || [http://guzzlephp.org/api/class-Guzzle.Common.Log.LogAdapterInterface.html LOG Object] || BEAR\Sunday\Inject ||
|| `ResourceInject` || [http://code.google.com/p/bearsunday/wiki/resource_client Resource Client] || BEAR\Sunday\Inject ||