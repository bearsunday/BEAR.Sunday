# BEAR.Sunday

## A resource oriented framework

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/badges/quality-score.png?b=develop-2)](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/?branch=develop-2)
[![Code Coverage](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/badges/coverage.png?b=develop-2)](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/?branch=develop-2)
[![Build Status](https://travis-ci.org/bearsunday/BEAR.Sunday.svg?branch=develop-2)](https://travis-ci.org/bearsunday/BEAR.Sunday)

## What's BEAR.Sunday

This resource orientated framework has both externally and internally
 a **REST centric architecture**,  implementing **Dependency Injection** and
**Aspect Orientated Programming** heavily to offer you surprising
simplicity,  order and flexibility in your application. With very
 few components of its own, it is a fantastic example of how a framework
 can be built using  existing components and libraries from other
frameworks, yet offer even further benefit and beauty.

## Everything is a resource

In BEAR.Sunday **everything is a REST resource** which leads to far simpler design and extensibility.
Interactions with your database, services and even pages and sections of your app all sit comfortably in a resource which can be consumed or rendered at will.

## GET - Hello World

The resource class receive a named argument over the query parameters of the URL.

```php
class Hello extends Page
{
    public function onGet($name = "World")
    {
        $this['greeting'] = "Hello " . $name;
        return $this;
    }
}
```
```html
<!DOCTYPE html>
<html lang="en">
    <body>
        {$greeting}
    </body>
</html>
```
## Building a Hypermedia-Driven RESTful Web Service in 1 min

Hypermedia is an important aspect of REST. It allows you to build services that decouple client and server to a large extent and allow them to evolve independently. The representations returned for REST resources contain links that indicate which further resources the client should look at and interact with. Thus the design of the representations is crucial to the design of the overall service.

### Create project

    composer create-project bear/skeleton:~1.0@dev MyVendor.MyPackage
    cd MyVendor.MyPackage
    composer install

### Create a resource class

`src/Resource/App/Greeting.php`

```php
<?php

namespace MyVendor\MyPackage\Resource\App;

use BEAR\Resource\ResourceObject;

class Greeting extends ResourceObject
{
    public function onGet($name = 'World')
    {
        $this['greeting'] = 'Hello, ' . $name;

        return $this;
    }
}
```

That's all.

### Test the service

Use the built-in PHP server.
```
php -S localhost:8080 bootstrap/api.php
```

Now that the service is up, visit http://localhost:8080/greeting, where you see:
```
{
    "greeting": "Hello, World",
    "_links": {
        "self": {
            "href": "/greeting"
        }
    }
}
```
JSON representation of a greeting enriched with the simplest possible hypermedia element, a link pointing to the resource itself:

Congratulations! You’ve just developed a hypermedia-driven RESTful web service with BEAR.Sunday.

## Application

Application execution sequence is scripted by the user-defined [application script](https://github.com/bearsunday/BEAR.Sunday/blob/develop-2/docs/demo/MyVendor.Helloworld/www/index.php).

Application services are just stored in [one object variable](http://bearsunday.github.io/readme/print_o/app.html).
You can access all resource of application with resources clients, easy use from plain PHP files or CMS and other frameworks as well.

Dependency injection
--------------------
It is google guice style DI framework.

### Binding
```php
$this->bind(Annotations::class)
     ->to(FileCacheReader::class)
     ->in(Scope::SINGLETON);
```

### Consumer

```php

public function __construct(Annotations $reader)
{
    $this->reader = $reader;
}
```

## Aspect oriented programming
Many features of the framework are implemented as an aspect.

### Interceptor

```php
class WeekendBlocker implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        $today = getdate();
        if ($today['weekday'][0] === 'S') {
            throw new \RuntimeException(
                  $invocation->getMethod()->getName() . " is not allowed on weekends!"
            );
        }
        return $invocation->proceed();
    }
}
```
### Service

```php
class RealBillingService implements BillingService
{
    /**
     * @WeekendBlock
     */
    public function chargeOrder()
    {
        ...
    }
}
```
### Weaving an Interceptor
```php
$this->bindInterceptor(
    $this->matcher->any(),
    $this->matcher->annotatedWith('WeekendBlock'),
    [WeekendBlocker::class]
);
```

## RESTful Service

Resource object fusion resources and web PHP class.

### Resource object
```php
class Greetings extends AbstractObject
{
    public function onGet($lang = 'en')
    {
        $this['greeting'] = $this->message[$lang];
        return $this;
    }
}
```
### Resource client

```php
use ResourceInject;

$this->resource->get->uri('app://self/greetings')->withQuery(['lang' => 'ja'])->eager->request();
```
### Resource Object Diagram
![Resource Object Diagram](http://bearsunday.github.io//images/screen/diagram.png "Resource Object Diagram")

### How to run test and HelloWorld demo
```
$ composer create-project --dev bear/sunday:~1.0@dev
$ cd sunday
$ phpunit
$ cd docs/demo/MyVendor.HelloWorld/
$ composer install
$ phpunit
$ cd www
$ php -S 127.0.0.1:8080
```

### Links

 * [Homepage](http://bearsunday.github.io/)
 * [BEAR.Package](https://github.com/koriym/BEAR.Package/) - a web application frame work package for BEAR.Sunday

### Requirements

 * PHP 5.5+
 * hhvm
