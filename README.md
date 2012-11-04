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

### Binding
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
Aspect oriented progrmaming
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
                      $invocation->getMethod()->getName() . " is not allowed on weekends!"
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
Rather than reinvent the wheel and develop our own library, BEAR.Sunday uses (or will use) these great libraries.

 * [Aura/Router](https://github.com/auraphp/Aura.Router)
 * [Aura/Signal](https://github.com/auraphp/Aura.Signal)
 * [Aura/Web](https://github.com/auraphp/Aura.Web)
 * [Doctrine/Common](http://www.doctrine-project.org/projects/common)
 * [Doctrine/DBAL](http://www.doctrine-project.org/projects/dbal)
 * [Guzzle/Guzzle](http://guzzlephp.org/ "Guzzle")
 * [Pagerfanta](git://github.com/whiteoctober/Pagerfanta.git)
 * [Smarty3](http://www.smarty.net/)
 * [Twig/Twig](http://twig.sensiolabs.org/ "Twig")
 * [Haanga](http://haanga.org/ "Haanga")
 * [Symfony/HttpFoundation](https://github.com/symfony/HttpFoundation)
 * [Symfony/Validator](https://github.com/symfony/Validator "Symfony.Validator")
 * [Zend/Log](https://github.com/zendframework/zf2)

## Requirements

 * php 5.4
 * [APC](http://jp.php.net/manual/en/book.apc.php)

### optional
 * [xhprof](http://jp.php.net/manual/en/book.xhprof.php)
 
### php.ini
    apc.enable_cli = 1
    xhprof.output_dir = /tmp

BEAR.Package
------------

BEAR.Package is a simple sandbox application using BEAR.Sunday.
See how to install and use at https://github.com/koriym/BEAR.Package.