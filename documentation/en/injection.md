#summary Injection

# Introduction 

If the framework previously changes the binding interface you can change application behavior.
Also for injection code readability you can more easily use dependencies through a setter that uses a trait.

## Interfaces with Bindings 

`FrameworkModule` handles BEAR.Sunday frameworks core bindings.
If the application changes these bindings the specified and also characteristic behavior can be changed. 

For example In order to change the handling of raising exceptions, you bind the exception handling class that you made yourself to `BEAR\Framework\Exception\ExceptionHandlerInterface`. 

|| *Interface* || *Provider or Class Bound to* || *Contents* || 
|| `BEAR\Framework\Exception\ExceptionHandlerInterface` || `BEAR\Framework\Exception\ExceptionHandler` || Exception Handling ||
|| `BEAR\Framework\Web\ResponseInterface` || `BEAR\Framework\Web\SymfonyResponse` || HTTP Output ||
|| `BEAR\Framework\Output\ConsoleInterface` || `BEAR\Framework\Output\Console` || Console Output ||
|| `Doctrine\Common\Annotations\Reader` || `Doctrine\Common\Annotations\AnnotationReader` || Annotation Reader ||
|| `BEAR\Resource\LoggerInterface` || `BEAR\Framework\Module\Provider\ResourceLoggerProvider` || Resource Logger ||
|| `BEAR\Framework\Application\LoggerInterface` || `BEAR\Framework\Module\Provider\ResourceLoggerProvider` || Application Logger ||
|| `Guzzle\Parser\UriTemplate\UriTemplateInterface` || `Guzzle\Parser\UriTemplate\UriTemplate` || URI Template ||
|| `BEAR\Framework\Resource\Taggable` || `BEAR\Framework\Resource\Etag` || Cache Key ||
|| `Guzzle\Common\Cache\CacheAdapterInterface` || `BEAR\Framework\Module\Provider\ApcCacheProvider` || Cache Adapter ||

## Application Binding 

There are also interfaces whose bindings are sought for application mode or behavior.  
For example how resource should render itself (HTML or JSON ?) or what template engine or caching library it should use.
Generally `AppModule` is used.

|| *Interface* || *Class Bound to* || *Service* ||
|| `BEAR\Resource\Renderable` || `BEAR\Framework\Resource\View\Renderer` || HTML||
|| `BEAR\Framework\Resource\View\DevRenderer` || HTML for Dev ||
|| `BEAR\Framework\Resource\View\JsonRenderer` || JSON ||
|| `BEAR\Framework\Resource\View\HalRenderer` || JSON+HAL　||
|| `BEAR\Framework\Resource\View\TemplateEngineAdapter` || `BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter` || Smarty ||
|| `Guzzle\Common\Cache\CacheAdapterInterface @Named("resource_cache")` || `BEAR\Framework\Module\Provider\ApcCacheProvider` || Resource Cache ||

### Framework Binding and Binding Change Timing 
Before you install ``` $this->installModule() ``` and the framework module you run your bindings.

## Trait Injection 

To improve code readability and for simplification, for setter methods code we can use traits.

In using the trait name assignment `"{PropertyName}Inject"` the dependency will be inject into the property of that name. 
For example if you use the `TmpDirInject` trait, the 'Tmp Directory' dependency will be injected into the `tmpDir` property.

Example)
```
class Foo {
    use TmpDirInject;

    public function onGet()
    {
        $tmpDir = $this->tmpDir;
        ...
```

## List of Trait Names 


|| *Trait Name* || *Dependency Injected* ||
|| `TmpDirInject` || Tmp Directory ||
|| `LogDirInject` || Log Directory ||
|| `AppDirInject` || App Directory ||
|| `LogInject` || [http://guzzlephp.org/api/class-Guzzle.Common.Log.LogAdapterInterface.html Log Object] ||
|| `ResourceInject` || [http://code.google.com/p/bearsunday/wiki/resource_client Resource Client] ||