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

Testing BEAR.Sunday
------- 

Here's how to install Ray.Aop from source to run the unit tests and sample:

```
$ git clone git://github.com/koriym/BEAR.Sunday.git
$ git submodule update --init
$ phpunit
$ php tests/runall.php
```
