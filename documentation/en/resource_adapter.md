---
layout: default
title: BEAR.Sunday | Resource Adapter
category: Resource
--- 
# Resource Adapter

Depending on the application the resource URI's schema is bound the specified resource adapter and that request is carried out.

## Binding DSL 

```
$schemeCollection = new SchemeCollection;
$schemeCollection->scheme('app')->host('self')->toAdapter($appAdapter);
$schemeCollection->scheme('page')->host('self')->toAdapter($pageAdapter);
$schemeCollection->scheme('page')->host('*')->toAdapter($httpAdapter);
$this->bind('BEAR\Resource\SchemeCollection')->toInstance($schemeCollection);
```

The above bindings ensure the handling of resources that begin with`app://self/`, `page://self/` and even `http://`. The actual request is handled by the resource adapter (`$appAdapter` etc).

This kind of URI and the specified execution are not fixed, they are configured through the application binding.

## Resource Adapter 

The resource adapter is actually a factory of the resource object. It runs the `BEAR\Resource\Provider` methods and an object is returned.

For example if it is `app` or `page` from the URI we can find out the class name and return an instance of the resource object class. If it is `http` we can return the object returned from the `HTTP Client Service`. We also return the resource status from the method that corresponds to the request methods like `onGet` etc.

```
App implements ResourceObject, Provider, Adapter
{
    private $injector;
    private $namespace;
    private $path;

    /**
     * Constructor
     *
     * @param InjectorInterface $injector  Application dependency injector
     * @param string            $namespace Resource adapter namespace
     * @param string            $path      Resource adapter path
     *
     * @Inject
     */
    public function __construct(
        InjectorInterface $injector,
        $namespace,
        $path
    ){
        if (! is_string($namespace)) {
            throw new RuntimeException('namespace not string');
        }
        $this->injector = $injector;
        $this->namespace = $namespace;
        $this->path = $path;
    }

    /**
     * (non-PHPdoc)
     *
     * @see    BEAR\Resource.Provider::get()
     * @return object
     * @throws Exception\Host
     */
    public function get($uri)
    {
        $parsedUrl = parse_url($uri);
        $path = str_replace('/', ' ', $parsedUrl['path']);
        $path = ucwords($path);
        $path = str_replace(' ', '\\', $path);
        $host = $parsedUrl['host'];
        $className = "{$this->namespace}\\{$this->path}{$path}";
        $instance = $this->injector->getInstance($className);

        return $instance;
    }
}
```

_In the constructor we have injected for us the resource object  base directory and injector, and we return an instance that has those dependencies resolved. The only difference is `app`, `page` and where they are saved_

## Multiple application resources 

The injector contains all of the logic of how the objects are built. So if it was possible to obtain  an injector from a different application, in a unified instance you could handle multiple application resources.

For example a project that has a crosscutting application or an authentication API for within the organization. Unlike HTTP or Thrift it does not go outside of the network, it is handles in the same instance. 

```
$entries1 = $resource->get->uri('app://self/entries')->eager->request();
$entries2 = $resource->get->uri('app://anohter_service/entries')->eager->request();
```

## Wrapping Legacy API's 

When you wrap a legacy API you can it can then be easily used for things like logging, caching or for displaying in a debug screen. It also becomes easy to refactor an abstracted API. A resource adapter can then act as an API proxy.

```
$entries1 = $resource->get->uri('office://self/room/resrvation/')->eager->request();
```

## URI Possibilities 

It is at the crux of BEAR.Sunday to be able to add a name (URI) to the data you are dealing with and for everything to be available as an `API`. There is no fixed schema that is dictated to you by the framework, that binding is in the application domain.

As a resource API data that has a URI can function as hub even for badly written systems.
Different frameworks, different languages in other words multiple types of client(Web / Mobile App / Console), or storage changes, R/W splitting of storage(CQRS) etc. With all of these at the heart of the hub this functionality is possible.