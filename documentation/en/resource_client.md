---
layout: default
title: BEAR.Sunday | Resource Client
category: Resource
--- 
# Resource Client


BEAR.Sunday makes requests to each type of resource using the resource client. It sets the request method, URI, parameters builds the resource request then makes that request.

## Preperation 
In order to inject the resource client object in the class wanting to the use the resource client from the injector, the resource client setter method is used. Using a trait is handy.

```
use BEAR\Sunday\Inject\ResourceInject;

class Edit extends Page
{
    use ResourceInject;
```

With this the the resource client is assigned to the resource property, using `$this->resource` you can access the resource client.

## Request DSL 

```
$this
->resource
->get
->uri('app://self/blog/posts')
->withQuery(['id' => 1])
->eager
->request();
```

In this example the resource *`app://self/blog/posts`* with request `?id=1` is immediately made (eager).


The request is created with each method, URI, query component.
Each of those build component is used to create the request as DSL like in the example above and then executed.

### Request Method 

There are 4 operations that can be made on the resource get, put, post and delete. If you include the `options` method that queries what operations and methods can be made on the resource then it is 5.

### Request URI 
A BEAR.Sunday resource has the same kind of structure as a www URI.

```
{schema}://{application}/{path}
```
{schema} shows the resource type, {application} is itself which points to `self`. In BEAR.Sunday page controller is also handled as a page resource. The application resource schema that matches the model is `app`.

A top page with have the following expression. (a `page` resource in ones own application `self` with the `index` path)
```
page://self/index
```

The blog post application resource in the sandbox application has the following expression.
```
app://self/blog/posts
```

The schema's page/app correspond to the following files, classes.

|| URI || Class || File ||
|| page://self/index || Sandbox\Resource\Page\Index ||Sandbox/Resource/Page/Index.php ||
|| app://self/blog/posts || Sandbox\Resource\App\Blog\Posts || Sandbox/Resource/App/Blog/Posts.php ||

It is possible to implement an original schema as an resource adapter on the application side. For example a pre-existing "office" service service is running in some shape or form. Create the office schema, then wrap that service with an adapter and then access it using `office://{service-path}`.

When you want to use legacy data systems rather than access objects directly it is better to create a schema and a resource adapter.

### Request Query 

In a request query you can pass named parameters. These are not standard php ordered parameters, they are parameters that are specifically named.

A query set as ['id' => 1] will correspond with the following resource request method. Set the parameter names. Any ordering of them is ignored.

```
public function onGet($id)
{
}
```

A request object is an object that contains all of the needed logic for the request. This can also assign to templates and assess latency.

### Request Timing 

A resource request has `lazy` and `eager` options. Any request that is not assigned `lazy` will default to an `eager` request.

#### Lazy Request 
```
$this['posts'] = $this->resource->get->uri('app://self/posts')->request();
```

#### Eager Request 
```
$this['posts'] = $this->resource->get->uri('app://self/posts')->eager->request();
```

The response of a resource request *with* eager is the result.
The response of a request *with out* eager is a request class that implements the request interface (BEAR\Resource\Requestable）

When this request is assigned to a template, it will only be resolved when the element is used. So if the request is not used in a view then the request is never made. This delayed evaluation we call (Lazy Evaluation).

### Link 

You can link resources. The result of a resource links resources as the next resource input. A selfLink that replaces resources, addLink adds resources to other resource and crawlLink that links to multiple resources.

Link functionality encapsulates the relational nature between resources. The client you use does not understand the actual relational nature, but can use the relationships. This is easy to understand if you liken it to a web `a` tag. The url of the l

The url info of the forward links is not controlled by the client but by the service itself.
The user just clicks the link text.

### EOR(End of Request) 

The built up request is closed by the `request()` method. If it is an eager request then the result, if it is lazy then the request object is returned in the response.

## Resource Renderer 

The resource status or the presentation of the resource result is the renderer that is contained in the resource's job. Not the user of the resource. For example this is different to in MVC where the controller gets data from the model and passes it the view. The resource each internally contains a resource renderer, without querying outside is set to know how to render itself.

The renderer is injected through dependency injection. You can change the renderer to another renderer in the application module that carries out the DI configuration. For example when in development the DevRenderer that contains extra development information is injected. When creating a Web API for example the JsonRenderer is injected.

## Resource Rendering 

The resource does contain a specific method for rendering. When evaluated as as string and when a string is returned from as a result from the renderers rendering. Below is an example. 

```
$userHtml = (string) $user; // Type conversion
echo $user;
```

## Template Representation  

|| String || {$posts} || The string of the result that has been rendered by the template engine || 
|| Array || {$posts['id']} || Accessing the associative array result  ||
|| Object || {$posts->header} || Accessing the object result ||

※No matter whether eager or lazy there is no difference in template rendering.