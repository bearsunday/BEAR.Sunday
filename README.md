BEAR, a resource oriented framework.
=============================

 * preview release 2nd 

## Requirement

 * php 5.4+
 * (APC, Memcache , cURL)
 
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

 * [Aura.Autoload](https://github.com/auraphp/Aura.Autoload "Aura.Autoload")
 * [Aura.Router](https://github.com/auraphp/Aura.Router "Aura.Router")
 * [Aura.Signal](https://github.com/auraphp/Aura.Signal "Aura.Signal")
 * [Aura.Web](https://github.com/auraphp/Aura.Web "Aura.Web")
 * [Doctrine.Common.Annotation](http://www.doctrine-project.org/projects/common "Doctrine.Common")
 * [Doctrine.Common.Cache](http://www.doctrine-project.org/projects/common "Doctrine.Common")
 * [Doctrine.DBAL](http://www.doctrine-project.org/projects/dbal "Doctrine.DBAL")
 * [Guzzle](http://guzzlephp.org/ "Guzzle")
 * [Haanga](http://haanga.org/ "Haanga")
 * [Smarty3](http://www.smarty.net/ "Smarty3")
 * [Symfony.Validator](https://github.com/symfony/Validator "Symfony.Validator")
 * [Twig](http://twig.sensiolabs.org/ "Twig")
 * [Zend.Cache](https://github.com/zendframework/zf2)
 * [Zend.Log](https://github.com/zendframework/zf2)

Testing BEAR.Sunday
------- 

Here's how to install Ray.Aop from source to run the unit tests and sample:

	$ git clone git://github.com/koriym/BEAR.Sunday.git
	$ cd BEAR.Sunday
	$ git submodule update --init
	$ phpunit
	$ php tests/runall.php

### buil-in web server

	$ php -S localhost:8080 apps/demoworld/htdocs/dev.php
	
	
	http://localhost:8080/hello
	http://localhost:8080/template/haanga
	http://localhost:8080/template/twig
	http://localhost:8080/template/smarty3

### CLI for HTML

	$ php apps/demoworld/htdocs/dev.php get /hello

### CLI for API

	$ php apps/demoworld/htdocs/api/dev.php get page://self/hello
	$ php apps/demoworld/htdocs/api/dev.php get app://self/greeting?lang=ja
