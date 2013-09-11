---
layout: default
title: BEAR.Sunday | Resource Introduction
category: Resource
--- 

#summary Resource Introduction

# Introduction 

## Representational State Transfer 

[REST](http://en.wikipedia.org/wiki/REST) (Representational State Transfer) was first introduced in a doctorate paper in 2000 by key creator of the HTTP specification Roy Fielding.

A resource is a clump of information containing meaning. A representation is created from the resource state and then passed to the client. This what REST (Representational State Transfer) is. For example stock information is a resource. From that state to a HTML page representation is created then passed to a web browser and becomes a stock information page. This is REST.

## Application Resource 

In an MVC framework just like a controller accesses a model, in BEAR.Sunday a page resource requests an application resource.

The model does not deal with data in an object based architecture instead deals with the data as a REST resource. The resource functions as a layer, internal procedures or objects can be wrapped and served as a resource. The resource client does not deal directly with an instance, 
the resource object retrieved using a URI is processed through a request interface. 

Object Model

|| *cart:* || show, addItem, remoteItem, addCoupon, removeCoupon, increaseQuantity, decreaseQuantity ||

REST

|| *`cart`* || get, post, put, delete || 
|| *`cart/item`* || get, post, put, delete || 
|| *`cart/coupon`* || get, post, put, delete || 

## ROA(Resource Orientated Architecture) 
A BEAR resource also just like an HTTP Application carries the following 4 ROA([http://en.wikipedia.org/wiki/Resource-oriented_architecture Resource Orientated Architecture） Benefits

 * Addressability
 * Unified Interface
 * Statelessness
 * Connectedness (Links)

### Addressability 

A resource has a URI like a web URL.

```
app://self/blog/posts/?id=3
```

```
page://self/index
```

The equivalent to a MVC model is an application resource. In BEAR.Sunday a resource functions as an internal API, but as it is designed using REST it also works as an external API transport. In BEAR.Sunday the `Page` that carries out the page controller role is also a resource. A page according to its URL calls an application resource and builds itself.

A resource respects `the concern of each domain`. In order to build itself an article displaying *page* resource sets its own contents by setting its body property with an `Article application resource`. Here no concern is paid to the page article details. The role of the page is to bind part of itself to application resource request.

The schema expresses each individual domain (data structure) such as `app`, `page` and others just like `http` is available for the user to register. For example as a specified schema `office://self/room/meething/reservation/?room=3` etc and traditional information systems can provide a new URI.

For more information on custom schema's and other service request details then please see [resource_adapter Resource Adapter]. Furthermore `self` represents ones own service. It is an identifier to to be able to distinguish from other services.

### Uniform Interface 

The resource state (data) operates though an interface. That operation is run by the resource client. 

Let's think of it as an HTTP Application. A resource can be requested from an HTTP client, however that it is limited to the predetermined uniform methods GET/PUT/POST...etc. No matter what the resource these methods will not change.

BEAR.Sunday resources also have 4 interfaces conforming to the 4 HTTP methods.

|| GET || Resource retrieval ||
|| PUT || Resource update and creation ||
|| POST || Resource creation ||
|| DELETE || Resource delete ||
|| OPTIONS || Resource access method query ||

#### GET 
Resource reading. This method does not provide any changing of the resource state. A safe method with no side affects.

#### PUT 
Performs resource updates and also creation. This method has the benefit that even if you run it once, running it many more times will have no more effect. See [Idempotence](http://en.wikipedia.org/wiki/Idempotence).

#### POST 
Performs resource creation. If you run the request multiple times the resource will be created that many times. A method with no idempotence.

#### DELETE 
Resource deletion. Has idempotence just as PUT.

#### OPTIONS 
Inspects which methods and parameters can be used on the resource. Just like `GET` there is no effect on the resource.

## Stateless 

This means that there is no state involved in the resource request.

For example there is a state in the request when accessing a model object.

```
$user = new User;
$user->setUserId($id); 
$name = $user->getName(); // Follows the premise that there is state through the setting of $id
```

In a resource request there is no state.
```
$name = $resource
  ->get
  ->uri('app://self/user')
  ->eager
  ->request(['id' => 1)
  ->body['name'];
```


## Link 

A resource can link to other resources. For example a user resource can be linked to a blog resource by a *blog link*. A blog resource can be linked to a article resource via a *latest articles link* or *popular posts link*.

A link encapsulates the resource internals, externally from a resource you only need to follow the link. It is an just like an HTML `a` tag. The link info set by an `href` is not managed by the client but only used. Even the link location changes there is no change in the the way the link is handled.

A DB relationship or association is independent and so for example if a specific DB data column cam be linked to a http resource using a Web API or linked to data (a resource) crossing a schema.

# REST and BEAR.Sunday 

If all of this sounds quite abstract to you, you are right — REST in itself is a high-level style that could be implemented using many different technologies, and instantiated using different values for its abstract properties. For example, REST includes the concepts of resources and a uniform interface — i.e. the idea that every resource should respond to the same methods. But REST doesn't say which methods these should be, or how many of them there should be.

One `incarnation` of the REST style is HTTP (and a set of related set of standards, such as URIs), or slightly more abstractly: the Web’s architecture itself. To continue the example from above, HTTP “instantiates” the REST uniform interface with a particular one, consisting of the HTTP verbs. (http://www.infoq.com/articles/rest-introduction)

At the core of BEAR.Sunday is REST. It behaves like HTTP or web architecture by retrieving a clump of data/process as a resource. BEAR.Sunday as an API or a web framework collects and builds up these resources.

## REST Reference Links 

    * [REST(Wikipedia)](http://en.wikipedia.org/wiki/REST)
    * [http://www.infoq.com/articles/rest-introduction infoQREST Introduction]
    * [http://net.tutsplus.com/tutorials/other/a-beginners-introduction-to-http-and-rest/  Introduction to HTTP and REST]
    * [http://www.ustream.tv/recorded/485516 REST & ROA Best Practice]