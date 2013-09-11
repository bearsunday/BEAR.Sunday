---
layout: default
title: BEAR.Sunday | Annotations
category: Others
---
# Annotations

Annotations are a collection of meta data applied to a class or a method.
In BEAR.Sunday [http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html Doctrine Annotations] are used.
Annotations written in the doc block comment of a method or class can be used to specify a DI injection point or as a marker for the AOP interceptor to bind to.

## Built-in Annotations 

There are default annotations already created for you in `BEAR.Framework` or `Ray.Di`.
`BEAR.Framework` annotations are pretty much for use in AOP, 
if they are not bound to anything there is no affect at runtime.

### Ray.Di 

|| Annotation || Meaning || Property ||
|| `@Inject` || Injection Point || optional:Optional ||
|| `@Named` || Injection Point Name || value:Name ||
|| `@Scope` || Scope || value:"singleton" or "prototype"(Default) ||
|| `@ImplementedBy` || Default Information || Class ||
|| `@ProviderdBy` || Default Provider || Provider ||

For details on Ray.Di please refer to the [manual](http://code.google.com/p/rayphp/wiki/Motivation?tm=6).

### BEAR.Framework 

|| Annotation || Meaning || Property || Interceptor ||
|| `@Cache` || Cache || value:キャッシュ秒数 || `BEAR\Framework\Interceptor\CacheLoader` ||
|| `@CacheUpdate` || Cache Update || n/a || `BEAR\Framework\Interceptor\CacheUpdate` ||
|| `@Db` || DAO Inject|| n/a ||`BEAR\Framework\Interceptor\DbSetter` ||
|| `@DbPager` || DB Pager || n/a || n/a ||
|| `@Transactional` || Transactional || n/a || `BEAR\Framework\Interceptor\Transaction` ||
|| `@Time` || Time || n/a || `BEAR\Framework\Interceptor\TimeStamper` ||

_There is currently no detailed explanations for interceptors. Please look at the source._

## User Annotations 

```
/**
* @Annotation
* @Target({"METHOD","CLASS"})
*
*/
class Foo
{
    public $value;
}
```

Here is an example of how you can attach annotations to methods and classes.
An annotation that has only one property in called a 'Single Value Annotation'.

```
/**
 * @Foo("bar")
 */
```
In this case `"bar"` has been assigned to the value property.
There are marker annotations that have no other properties. There are also *Full Annotations* that contain many properties.

For details see the `Doctrine Annotation` [manual](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html)