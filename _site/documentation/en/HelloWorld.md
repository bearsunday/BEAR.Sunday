#summary Hello World

# Hello World 

Lets take a look at how to use BEAR.Sunday in a bear-bones app (Excuse the pun).
This app we will create mainly by creating 3 files.

 * An application script for web/cli use - Helloworld/public/min.php
 * A 'Hello' page resource - Helloworld/Resource/Page/Hello.php
 * An instance script - Helloworld/scripts/instance.php

Through the instance script the application object is made, 
a request results in the hello page resource being rendered. 

## CLI / Web 

'Hello World' using CLI。

```
$ php /path/to/bear/apps/Helloworld/htdocs/min.php
```

Hello World using the PHP5.4 built-in web server.

```
$ php -S localhost:8088 /path/to/bear/apps/Helloworld/htdocs/min.php
```

# Resource Use Bear bones　

### Application script (Helloworld/public/min.php ) 

The application is executed as follows.

```
// application
$app = require dirname(__DIR__) . '/scripts/instance.php';
$response # $app->resource->get->uri('page://self/hello')->withQuery(['name' > 'World !'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
exit(0);

```

### Instance Script (Helloworld/scripts/instance.php) 

The script to create the application object.

```
$injector = Injector::create([new AppModule]);
$app = $injector->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
return $app;
```

## About the Application Script 

Lets go over the application script.

```
$app = require dirname(__DIR__) . '/scripts/instance.php';
```

Get the application instance form the script.

```
$response # $app->resource->get->uri('page://self/hello')->withQuery(['name' > 'World !'])->eager->request();
```

With the ($app->resource) resource client retrieve the resource with the URI `page://self/hello` using the `get` method. 
Assigning the query parameters using `eager->request()` we can straight away (eagerly) retrieve the response. 

```
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
```

As in an HTTP response the response object contains 3 properties - response code, headers and body.


## Hello Page Resource 

In MVC terms a controller in BEAR.Sunday is a page resource.　A page resource can accept query parameters, create and return an instance of itself.

*Helloworld/Resource/Page/Hello.php*

```
class Hello extends Page
{
    /**
     * @return self
     */
    public function onGet($name)
    {
        $this->body = 'Hello ' . $name;
        return $this;
    }
}
```

In MVC a page resource would be described as a controller, however the result is not passed to the template, 
In the manner of: `$this->body = 'Hello ' . $name;` the page object is created and $this is returned. 

As below if you return a string the result is the same. The resource object is returned to the client.

```
    {
        $body = 'Hello ' . $name;
        return $body;
    }
```

## Application Class 
*Helloworld/App.php*

The application object contains as properties all services needed by the application script.


In the module the object bound to the interface is injected by the constructor.

## Application Module 
*`Helloworld/Module/AppModule.php`*

The application module is a collection of dependencies, implementation bindings, methods and bindings of cross-cutting concerns used by the application.

The module unifies the settings of both the `DI` binding implementation of the injection point needed for injection and
Aspect Oriented Programing which binds the cross-cutting concerns interceptor to specific methods 
then handles the application construction.

By centrally setting up both Dependency Injection which statically binds an implementation to an "injection point" needed for the injection and Aspect Oriented Programing which binds cross-cutting concerns to a specific method the application is built up. 
