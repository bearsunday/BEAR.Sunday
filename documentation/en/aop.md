---
layout: default
title: BEAR.Sunday | Aspect Orientated Programming (AOP)
category: DI & AOP
---
# Aspect Orientated Programming (AOP)

With BEAR.Sunday's [http://en.wikipedia.org/wiki/Aspect-oriented_programming Aspect Orientated Programming(AOP)], you can for example with a `method annotated with *@Log* log the result` and you can do that *without changing the original method being called*.

AOP class does not directly affect the class, it is a way of each module to independently separate process logic that is shared between modules. For processing where many classes in which normally code duplication may creep in, we can use a technique where as an aspect (cross-cutting concerns) we can add this to a different module.

In the BEAR.Sunday framework there are many functions which the thinking is to gather aspects and implement cross-cutting functionality in AOP. When the object is created the `Injector` depending on conditions set in the module weaves the aspect to the respective method.

BEAR.Sunday uses an AOP framework called Ray.Aop which implements the [http://aopalliance.sourceforge.net/doc/org/aopalliance/intercept/MethodInvocation.html#getMethod%28%29 MethodInterceptor Interface] set out in the AOP Alliance which is similar to Google Guice or Springs implementation of AOP.

## Interceptor 

The interceptor takes hold of the method being called and performs cross-cutting processing on it. The interceptor implements the ```invoke``` method, inside that method the original method is called and the cross-cutting operations are performed.

```
public function invoke(MethodInvocation $invocation);
```

Below is a logger interceptor which logs the the parameters from the operation output.

```
class Logger implements MethodInterceptor
{
    use LogInject;

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();
        $class = get_class($invocation->getThis());
        $args = $invocation->getArguments();
        $input = json_encode($args);
        $output = json_encode($result);
        $log # "target = [{$class}], input = [{$input}], result  [{$output}]";
        $this->log->log($log);
        return $result;
    }
}
```

In this interceptor it uses the injected Log object, the called parameters and the result are logged in JSON format. This interceptor is bound to all resources in the sandbox application's DEV mode allowing you to easily debug your app.

This method the logger is bound to has no changes at all, yet logging functionality has been added.
The original method doesn't care if the logger changes or if it is added or removed.

The primary concern of the original method is its *(core concern)*, this is completely separated from the method that takes the logs the *(cross-cutting concern)*.

## Matcher Binding 

The interceptor you made operates by being bound to the method. You use the *matcher* to decides what method it will be bound to. The object below binds all methods that begin with `on` in classes that inherit from `BEAR\Resource\Object` to the injected log object.

```
$logger = $this->requestInjection('BEAR\Framework\Interceptor\Logger');
$this->bindInterceptor(
    $this->matcher->subclassesOf('BEAR\Resource\Object'),
    $this->matcher->startWith('on'),
    [$logger]
);
```

`bindInterceptor` takes 3 parameters, the first is a class match, the second is a method match and the 3rd in an interceptor.

|| Method Signature ||　Function ||
|| bool subclassesOf($class) || Specifies the subclass. Cannot be specified in multi-dimensional arrays.  ||
|| bool any() || Matches anything||
|| bool annotatedWith($annotation) || $annotation is the annotations full path. Matches whatever is marked with this annotation. ||
|| bool startWith($prefix) || Matches whatever class/method begins with this string||

For example when you specify the following method matching, methods that are named setXX are matched.
```
$this->matcher->startWith('set')
```

## `MethodInvocation` 

The interceptor receives the MethodInvocation model variables, wraps the method runtime before and after processing and uses the variables to invoke the original method.
The `MethodInvocation` main methods are as below.

|| Method Signature ||　Function ||
|| void proceed() || Run the target method ||
|| Reflectionmethod getMethod() || Retrieve the target method reflection ||
|| Object getThis() || Retrieve the target object ||
|| array getArguments() (|| Retrieve the argument array  || 
|| array getAnnotations() || Retrieve the target methods annotations ||

## Ray.Aop 
Please see the [Ray.Aop](http://code.google.com/p/rayphp/wiki/AOP) manual for more info on the framework BEAR.Sunday uses.