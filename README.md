BEAR, a resource oriented framework for PHP5.4
=============================

[![Build Status](https://secure.travis-ci.org/koriym/BEAR.Sunday.png?branch=master)](http://travis-ci.org/koriym/BEAR.Sunday)

One minute example
==================

Dependency injection
--------------------

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
--------------------------

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
        [new WeekendBlocker]
    );
```

RESTful Service
-----------

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

Dependencies
------------
Rather than reinvent the wheel and develop our own library, BEAR.Sunday are using these great libraries.

 * [Aura/Router](https://github.com/auraphp/Aura.Router)
 * [Aura/Signal](https://github.com/auraphp/Aura.Signal)
 * [Aura/Web](https://github.com/auraphp/Aura.Web)
 * [Doctrine/Common](http://www.doctrine-project.org/projects/common)
 * [Doctrine/DBAL](http://www.doctrine-project.org/projects/dbal)
 * [Guzzle/Guzzle](http://guzzlephp.org/ "Guzzle")
 * [Pagerfanta](git://github.com/whiteoctober/Pagerfanta.git)
 * [Smarty3](http://www.smarty.net/)
 * [Twig/Twig](http://twig.sensiolabs.org/ "Twig")
 * [Ray/Di](https://github.com/koriym/Ray.Di) ([Aura/Di](https://github.com/auraphp/Aura.Di))
 * [Ray/Aop](https://github.com/koriym/Aop.Di)
 * [Symfony/HttpFoundation](https://github.com/symfony/HttpFoundation)
 * [Symfony/Routing](https://github.com/symfony/Validator "Symfony.Validator")
 * [Nocarrier\Hal](https://github.com/blongden/hal)
 * [Zend/Log](https://github.com/zendframework/zf2)
 * [Zend/Db](git@github.com:zendframework/Component_ZendDb.git)

BEAR.Package
------------

BEAR.Package is a simple sandbox application using BEAR.Sunday.
See how to install and use at https://github.com/koriym/BEAR.Package.
