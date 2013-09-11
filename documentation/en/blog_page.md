---
layout: default
title: BEAR.Sunday | Blog Tutorial(4) Creating an index page
category: Blog Tutorial
---
# Page Resource 

## Creating a Page 

When creating a new page in BEAR.Sunday you normally make the following.

 * Page resource class
 * Page resource template

A page resource and application resource have the same configuration and have an interface. An application resource in its default state does not contain anything so we need to inject the DB object using dependency injection, we also need to inject dependencies into the page resource.

## Page Controller 

The equivalent of an MVC controller in BEAR.Sunday is a page resource. The page receives the page request, requests the application resource and builds itself. The page is then handled as it is as an output object.

 Note: In BEAR.Sunday you can also use a router, however in this blog application we won't be using one.

 Note: In a BEAR.Sunday site 1 page has 1 page resource class which conforms to the  _[http://www.martinfowler.com/eaaCatalog/pageController.html Page Controller]_ principle. 

## Page Class 

The role of this posts index page is to *retrieve through a GET request the application API's posts resource and assign them to the pages posts slot*.

In the [Application resource app_resource] section we ran the application resource from the console, however when requesting a resource in PHP we need to use a resource client. The resource client can be injected by using a trait.

Through the `use` keyword descriptor we can use a trait as below, and then the resource client will be injected into the `$resource` property.
```
    use ResourceInject;
```

In order to make a resource request using the injected resource client you do something like below.
```
$this->resource->get->uri('app://self/posts')->request()
```

When this is put together you can do the following.

```
<?php
namespace Sandbox\Resource\Page\Blog;

use BEAR\Resource\AbstractObject as Page;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation;

class Posts extends Page
{
    use ResourceInject;
	
    public $body = [
        'posts' => ''
    ];

    /**
     * Get
     *
     * @Cache
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/posts')->request();
        return $this;
    }
}

```
A request to `app://self/posts` is made then is stored in the posts slot of the current resource.

  Note: $this['posts'] is some syntax sugar which is an abbreviation of $this->body['body'].
  Note: This is different to an MVC controller as you will notice there is no attention paid to output. There is no assignment of variables etc for a template.

## A Page as a Resource 

So just like an application resource lets access the page resource from the console.

```
$ php api.php get page://self/blog/posts

200 OK
...
\[BODY]
{
    "posts": {
...
```

In the posts slot the result of request *get app://self/posts* is assigned.  

As the page resource plays the role of a page controller it also plays the role of an output object. Although pays no attention to how it is displayed.

## Resource Cache 

Where the page resource it is annotated with `@Cache`, in the sandbox application a method annotated as such is bound to the cache interceptor.

```
use BEAR\Sunday\Annotation\Cache;

...

/**
 * @Cache(30)
 */
```

  Note: For the cache FQN the `use` keyword descriptor is needed.

## Indefinite Caching 

In this page resource no cache time has been set, the resources GET request is cached indefinitely and the onGet method is only run once the first time. So even if posts are added or deleted will the displayed page not change?

The page posts index page resource role is to request the posts resource and set them in posts. That role is not dependent on the request, is immutable and this assignment is cached.

What is setting the page resource is not the request result instead it is the actual request itself. Even if the indefinite cache is configured with @Cache the cached posts resource is run reach time, the posts resource state is then reflected. (In this case the only cost saved by `@Cache` is merely creating the request inside the `OnGet()` method)

In other words the cache is cutting out the cost of building up the request.