BEAR, a resource oriented framework.
=============================

 * 0.1.0alpha
[![Build Status](https://secure.travis-ci.org/koriym/BEAR.Sunday.png?branch=master)](http://travis-ci.org/koriym/BEAR.Sunday)

## Requirement

 * php 5.4+
 * APC
 
One minute example
==================

Service
-----------

### Client side

```php
<?php
    use ResourceInject;
    
    $this->resource->get->uri('app://self/greetings')->withQuery(['lang' => 'ja'])->eager->request();
```

### Service side
```php
<?php
    class Greetings extends ResourceObject
    {
        public function onGet($lang = 'en')
        {
            $this['greeting'] = $this->message[$lang];
            return $this;
        }
    }
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

 * [Aura/Autoload](https://github.com/auraphp/Aura.Autoload "Aura.Autoload")
 * [Aura/Router](https://github.com/auraphp/Aura.Router "Aura.Router")
 * [Aura/Signal](https://github.com/auraphp/Aura.Signal "Aura.Signal")
 * [Aura/Web](https://github.com/auraphp/Aura.Web "Aura.Web")
 * [Doctrine/Common](http://www.doctrine-project.org/projects/common "Doctrine.Common")
 * [Doctrine/DBAL](http://www.doctrine-project.org/projects/dbal "Doctrine.DBAL")
 * [Guzzle/Guzzle](http://guzzlephp.org/ "Guzzle")
 * [Haanga](http://haanga.org/ "Haanga")
 * [Monolog](https://github.com/Seldaek/monolog.git "Monolog")
 * [Smarty3](http://www.smarty.net/ "Smarty3")
 * [Symfony/Validator](https://github.com/symfony/Validator "Symfony.Validator")
 * [Twig/Twig](http://twig.sensiolabs.org/ "Twig")
 * [Zend/Cache](https://github.com/zendframework/zf2)
 * [Zend/Log](https://github.com/zendframework/zf2)

Testing BEAR.Sunday
------- 

Here's how to install BEAR.Sunday from source to run the unit tests:

    $ git clone git://github.com/koriym/BEAR.Sunday.git
    $ cd BEAR.Sunday
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install
    $ chmod -R 777 apps/sandbox/tmp apps/sandbox/log
    $ phpunit

### buil-in web server

    $ cd apps/sandbox/htdocs
    $ php -S localhost:8080 dev.web.php
    $ curl http://localhost:8080/

### CLI

    $ php dev.web.php get /index
    $ php dev.api.php get app://self/greetings?lang=ja
    $ php dev.api.php get app://self/greetings?lang=en
    $ php dev.api.php get page://self/index
    $ php dev.api.php get page://self/index rep
