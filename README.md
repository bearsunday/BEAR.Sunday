BEAR, a resource oriented framework
===================================

[![Build Status](https://secure.travis-ci.org/koriym/BEAR.Sunday.png?branch=master)](http://travis-ci.org/koriym/BEAR.Sunday)

What's BEAR.Sunday
------------------

This resource orientated framework has both externally and internally
 a REST centric architecture,  implementing 'Dependency Injection' and 
'Aspect Orientated Programming' heavily to offer you surprising 
simplicity,  order and flexibility in your application. With very
 few components of its own, it is a fantastic example of how a framework
 can be built using  existing components and libraries from other 
frameworks, yet offer even further benefit and beauty. 

BEAR.SundayはアプリケーションをRESTアーキテクチャで構築するリソース指向フレームワークです。
「依存性の注入」と「アスペクト指向プログラミング」を用いた粗結合なシステムは意図が読みやすく簡潔なコーディングを可能にします。
BEAR.Sundayは独自のコンポーネントをほとんど持ちません。再発名を避け定評ある既存ライブラリを利用します。
コンポーネントそのものよりそれらの接続に注目し、開発者が構成可能でSOLIDなフレームを提供します。

Everythins is a resource
------------------------------
In BEAR.Sunday everything is a REST resource which leads to far simpler design and extensibility. Interactions with your database, services and even pages and sections of your app all sit comfortably in a resource which can be consumed or rendered at will. 

BEAR.Sundayではコントローラーもモデルも統一したリソースとして扱います。
名前(URI)と統一インターフェイスを持った各リソースはアプリケーション内部/外部に関わらずAPIとして機能し、
モバイルアプリケーションへの早期対応や高いインターオペラビリティ、長期運用を可能にします。

GET - Hello World
-----------------
The resource class receive a named argument over the query parameters of the URL.
![Halo](http://koriym.github.io/BEAR.Sunday/images/screen/url.png)

```php
class Hello extends Page
{S
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

Method-Override
---------------
`Method-Override` or `_method` used for DELETE / PUT method.

```html
<input name="X-HTTP-Method-Override" type="hidden" value="PUT"/>
<input name="X-HTTP-Method-Override" type="hidden" value="DELETE"/>
```

```
http://myapp/entry/10/?_method=DELETE
````


Development tools
-----------------

Frame called 'Halo' appears around the resources in development mode.

![Halo](http://koriym.github.io/BEAR.Sunday/images/screen/hello.png)

Cache state or URI of the resource is displayed, as well as the tool icon within the halo.

![resource representation](http://koriym.github.io/BEAR.Sunday/images/screen/html.png)

It is possible to edit and save resources logic and template directly on the web.It will help in quick iteration and collaboration.

![Halo](http://koriym.github.io/BEAR.Sunday/images/screen/editor.png)


### Resource list

You can list for a resource of application.

![resource list](http://koriym.github.io/BEAR.Sunday/images/screen/resource_list.png)


### Object graph visualizer

Object graph visualizer, you can visualize the complex structure of the object, and examine the contents.

![object gragh](http://koriym.github.io/BEAR.Sunday/images/screen/object_graph.png)

Console access
--------------

### for web
Resources can also be accessed from the console.
```bash
$ php web.php get '/hello/world?name = World '

200 OK
date: ["Tue, 07 May 2013 07:25:58 GMT"]
</body>
greeting: Hello World
[VIEW]
<!DOCTYPE html>
<html lang="en">
<div class="container">
    <h1> Hello World </ h1>
</div>
</body>
</html>
```

### for API (HAL)

```php
$ php api.php get 'page://self/hello/world?name=World'
200 OK
date: ["Tue, 07 May 2013 07:28:09 GMT"]
[BODY]
greeting: Hello World
[VIEW]
{
    "greeting": "Hello World",
    "_links": {
        "self": {
            "href": "page://self/hello/world"
        }
    }
}
```

Annotations
-----------

Aspects like Log or cache can be specified in the annotation 
```php
/**
* @Cache(60)
*/
public function onGet($name = "World")
{
```

```php
/**
* @Auth("admin")
*/
public function onGet($id)
{
```

```php
/**
* @Time
* @Transactional
* @CacheUpdate
* @Log
*/
public function onPost($title, $body)
{
```

SQL in the method is converted to paging enabled SQL with @ DbPager.

```php
/**
* @Db
* @DbPager(10)
*/
public function onGet($id)
{
```

Application Script
------------------
Application execution sequence is scripted by the user-defined application script.

```php
/**
* Here we get the production application instance. No $mode variable is needed as it defaults to Prod.
*
* @var $app \BEAR\Package\Provide\Application\AbstractApp
*/
$app = require dirname(__DIR__) . '/scripts/instance.php';

/**
* Calling the match of a BEAR.Sunday compatible router will give us the $method, $pagePath, $query to be used
* in the page request.
*/
list($method, $pagePath, $query) = $app->router->match();

/**
* An attempt to request the page resource is made.
* Upon failure the appropriate error code is assigned and forwarded to ERROR.
*/
try {
    $app->page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
} catch (NotFound $e) {
    $code = 404;
    goto ERROR;
} catch (MethodNotAllowed $e) {
    $code = 405;
    goto ERROR;
} catch (BadRequest $e) {
    $code = 400;
    goto ERROR;
} catch (Exception $e) {
    $code = 503;
    error_log((string)$e);
    goto ERROR;
}

/**
* OK: Sets the response resources and renders
* ERROR: sets the response code and loads error page.
*/
OK: {
    $app->response->setResource($app->page)->render()->send();
    exit(0);
}

ERROR: {
    http_response_code($code);
    require dirname(__DIR__) . "/http/{$code}.php";
    exit(1);
}

```

Application Object
------------------
Application is just stored in one object variable. 
You can access all resource of application with resources clients, easy use from plain PHP files or CMS and other frameworks as well.

```php
<?php

$app = require 'MyApp/scripts/instance.php';
$hello = $app
->resource
->get
->uri('app://self/hello')
->withQuery(['name' => 'Pull world !'])
->eager
->request();

?>
<html>
<body>
greeting: <?php echo $hello['greeting']; ?>
time: <?php echo $hello['time']; ?>
</body>
</html>
```


Dependency injection
--------------------
It is google guice style annotation-based DI framework.

### Binding
```php
    $this->bind('Doctrine\Common\Annotations')
         ->to('Doctrine\Common\Annotations\FileCacheReader')
         ->in(Scope::SINGLETON);
```

### Consumer
```php
    /**
     * @Inject
     */
    public function __construct(Annotations $reader)
    {
        $this->reader = $reader;
    }
```

Aspect oriented programming
---------------------------
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
}S
```
### Weaving an Interceptor
```php
$ This-> bindInterceptor (
    $ This-> matcher-> any (),
    $ This-> matcher-> annotatedWith ('WeekendBlock'),
    [New WeekendBlocker]
);
`` `

RESTful Service
---------------
Resource object fusion resources and web PHP class.

### Resource object
`` `Php
class Greetings extends AbstractObject
{S
    public function onGet($lang = 'en')
    {
        $this['greeting'] = $this->message[$lang];
        return $ this;S
    }S
}S
```

### Resource client

```php
use ResourceInject;
    
$this->resource->get->uri('app://self/greetings')->withQuery(['lang' => 'ja'])->eager->request();
`` `

Signal Parameter
----------------
Signal parameter makes it possible to pull architecture and reduction of boilerplate code under a special mechanism that argument provider dedicated to be prepared.

### parameter provider
```php
class CurrentTime implements ParamProviderInterface
{
    public function __invoke(Param $param)
    {
        $time = date("Y-m-d H:i:s", time());
        return $param->inject($time);
    }
}

```

### install

```php
protected function configure()
{
    $params = ['now' => 'CurrentTime'];
    $this->install(new SignalParamModule($this, $params));
}    
```

### consumer
```php

class Param extends Page
{
    /**
     * @param $now provided by parameter provider
     */
    public function onGet($now)
    {
        $this->body['now'] = $now;
        return $this;
    }
}

```

Performance
-----------
BEAR.Sunday will generate complex object graph with many cost in the first request, but the object will be re-used beyond the request.
A clear distinction between run-time and compile results in a performance and maximum flexibility to configure the system.

Dependencies
------------
Rather than reinvent the wheel and develop our own library, BEAR.Sunday are using these great libraries.

* [Aura / Router] (https://github.com/auraphp/Aura.Router)
* [Aura / Signal] (https://github.com/auraphp/Aura.Signal)
* [Aura / Web] (https://github.com/auraphp/Aura.Web)
* [Doctrine / Common] (http://www.doctrine-project.org/projects/common)
* [Doctrine / DBAL] (http://www.doctrine-project.org/projects/dbal)
* [Guzzle / Guzzle] (http://guzzlephp.org/ "Guzzle")
* [Pagerfanta] (https://github.com/whiteoctober/Pagerfanta)
* [Smarty3] (http://www.smarty.net/)
* [Twig] (http://twig.sensiolabs.org/ "Twig")
* [Ray / Di] (https://github.com/koriym/Ray.Di) ([Aura / Di] (https://github.com/auraphp/Aura.Di))
* [Ray / Aop] (https://github.com/koriym/Aop.Di)
* [Symfony / HttpFoundation] (https://github.com/symfony/HttpFoundation)
* [Symfony / Routing] (https://github.com/symfony/routing)
* [Nocarrier \ Hal] (https://github.com/blongden/hal)
* [Zend / Log] (https://github.com/zendframework/Component_ZendLog)
* [Zend / Db] (https://github.com/zendframework/Component_ZendDb)

Installation
------------

    $ curl -s http://install.bear-project.net/ | sh -s ./bear
or

    $ php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
    $ php composer.phar create-project --prefer-source --dev bear/package ./bear

More information is availavle at [wiki:install](http://code.google.com/p/bearsunday/wiki/install).

built-in web server for development
------------------

    $ cd bear/apps/Sandbox/public
    $ php -S localhost:8088 web.php
    $ php -S localhost:8089 api.php

Virtual Host for Production
------------
Set up a virtual host to point to the public / directory of the application.
