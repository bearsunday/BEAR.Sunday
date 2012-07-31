BEAR, a resource oriented framework for PHP5.4
=============================

[![Build Status](https://secure.travis-ci.org/koriym/BEAR.Sunday.png?branch=master)](http://travis-ci.org/koriym/BEAR.Sunday)

One minute example
==================

RESTful Service
-----------

### Resource object
```php
<?php
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
<?php
    use ResourceInject;
    
    $this->resource->get->uri('app://self/greetings')->withQuery(['lang' => 'ja'])->eager->request();
```
Dependency injection
--------------------

### Bidning
```php
<?php
    $this->bind('Doctrine\Common\Annotations')
         ->to('Doctrine\Common\Annotations\FileCacheReader')
         ->in(Scope::SINGLETON);
```

### Consumer
```php
<?php
    /**
     * @Inject
     */
    public function __construct(Annotations $reader)
    {
        $this->reader = $reader;
    }
```
Aspect oriented programing
--------------------------

### Interceptor
```php
<?php
    class WeekendBlocker implements MethodInterceptor
    {
        public function invoke(MethodInvocation $invocation)
        {
            $today = getdate();
            if ($today['weekday'][0] === 'S') {
                throw new \RuntimeException(
                      $invocation->getMethod()->getName() . " not allowed on weekends!"
                );
            }
            return $invocation->proceed();
        }
    }
```
### Service
```php
<?php
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
<?php
    $this->bindInterceptor(
        $this->matcher->any(),
        $this->matcher->annotatedWith('WeekendBlock'),
        [new WeekendBlocker]
    );
```

Dependencies
------------
Rahter than reinvent the wheel and develop our library, BEAR.Sunday use (or will use) these great libraries.

 * [Aura/Autoload](https://github.com/auraphp/Aura.Autoload)
 * [Aura/Router](https://github.com/auraphp/Aura.Router)
 * [Aura/Signal](https://github.com/auraphp/Aura.Signal)
 * [Aura/Web](https://github.com/auraphp/Aura.Web)
 * [Doctrine/Common](http://www.doctrine-project.org/projects/common)
 * [Doctrine/DBAL](http://www.doctrine-project.org/projects/dbal)
 * [Monolog](https://github.com/Seldaek/monolog.git)
 * [Pagerfanta](git://github.com/whiteoctober/Pagerfanta.git)
 * [Smarty3](http://www.smarty.net/)
 * [Symfony/HttpFoundation](https://github.com/symfony/HttpFoundation)
 * [Zend/Cache](https://github.com/zendframework/zf2)
 * [Zend/Log](https://github.com/zendframework/zf2)

 * [Haanga](http://haanga.org/ "Haanga")
 * [Twig/Twig](http://twig.sensiolabs.org/ "Twig")
 * [Symfony/Validator](https://github.com/symfony/Validator "Symfony.Validator")
 * [Guzzle/Guzzle](http://guzzlephp.org/ "Guzzle")

## Requirement

 * php 5.4
 * [APC](http://jp.php.net/manual/en/book.apc.php)

### optional
 * [xhprof](http://jp.php.net/manual/en/book.xhprof.php)
 
### php.ini
    apc.enable_cli = 1
    xhprof.output_dir = /tmp

Testing BEAR.Sunday
------- 

Here's how to install BEAR.Sunday:

    $ git clone git://github.com/koriym/BEAR.Sunday.git
    $ cd BEAR.Sunday
    $ wget http://getcomposer.org/composer.phar
    $ php ./composer.phar install
    $ chmod -R 777 apps/sandbox/tmp apps/sandbox/log

### buil-in web server
    
    $ cd apps/sandbox/htdocs
    $ php -S localhost:8088 web.php
    $ curl http://localhost:8088/

    $ php -S localhost:8089 api.php
    $ curl http://localhost:8089/blog/posts

### CLI

    $ php web.php get /index
    $ php api.php get app://self/greetings?lang=ja
    $ php api.php get app://self/greetings?lang=en
    $ php api.php get page://self/index
