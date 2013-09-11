---
layout: default
title: BEAR.Sunday | Resource Object
category: Resource
--- 

# Resource Object 

 _Representational State Transfer (REST) is a style of software architecture for distributed systems such as the World Wide Web...Individual resources are identified in requests, for example using URIs in web-based REST systems.- wikipedia "REST"_

BEAR.Sundays resource object takes these REST resource features and allows you build up these in a web application in an internal API.

A resource object can contain the resource state, request interface and links.

## Resource Object Type 

Resource objects are made distinct by their schema. In the current sandbox application there are 2 types the application resource (app） and page resource (page).

## Resource object class 

This hold the resource status and the request interface. Except for the query 1 URI corresponds to 1 class.

|| URI || Class || File ||
|| page://self/index || Sandbox\Resource\Page\Index ||Sandbox/Resource/Page/Index.php ||
|| app://self/blog/posts || Sandbox\Resource\App\Blog\Posts || Sandbox/Resource/App/Blog/Posts.php ||

The resources request resource interface is mapped to a PHP class.

  Note: The schema and the process are not fixed. The user can add names to the applications cross-cutting concerns and re-use them or pass the processing over to a mock for testing.

# Resource Property 
A resource has 5 public properties.

|| Property || Name || Meaning　|| Type ||
|| code || Code　|| Status || int ||
|| headers  || Header || Meta Data || array<$name => $value> ||
|| links || Link || Resource Link || array<$rel => $uri>  ||
|| body || Body || Resource Status || mixed ||
|| view || View || Resource View || string||

### Code 
Displays the resource status. When it is a page resource this is the HTTP status. The default is 200(OK). 

### Header 
The resources meta data. For example in a resource that handles paging, how many records are displayed or which page is currently being shown, pagers total records or even html for the navigation or other non essential meta data can be stored here. In the case of a page resource, these will be in the HTTP headers.

### Link 
The resource link functionality encapsulates the link relationships between resource. The active client can use the relationships without any knowledge relationships are implemented. Using the web a tag as example it is simple to understand. It is not the client that manages the link url's instead it is the web service, the user only needs to click on the link text. The relationship info is all contained within the resource not the client.

## Body 
The resources true value is in the body that displays the resource content.

Example) Car speed resource
```
(int) 60
```

Example) Car journey resource
```
[
 'speed' => 60,
 'passenger' => 1,
 'gear' => 4
 ...
]
```

## View 
The view is something that 'expresses' the resource. For example a resource for tomorrows weather could be something like the following.

Resource state: 'Sunny'
Resource expression: 'Weather: <img src="sky.gif">Sunny'

# Request Interface 

## Method 
A resource can contain an interface that responds to the request. For example a resource that only responds to a GET request will have an `onGet` method.

Example  a GET interface that responds to $id, $body, $title　as a query (parameters).
```
public function onGet($id, $body, $title = 'untitled') 
{
}
```

This is different to BEAR.Saturday which has the notation of a a regular PHP method. When using this you call it using named parameters the ordering is not important.

 Note: If you change the ordering there is no need to edit the calling side.
 Note: Where possible only receive scaler variables.
 

## Self Building 

The method that receives the request (Request Interface) can be change the resource status by means of a database, external web API or through business logic. (hence changing properties of the $body property, $headers or $code).
```
return $this
```

 Note: If anything other than $this is returned, that will be used to populate $body and $this is returned.
 Example) return 3; is the same as $this->body = 3; return $this;