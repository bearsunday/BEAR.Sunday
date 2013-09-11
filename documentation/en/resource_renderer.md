---
layout: default
title: BEAR.Sunday | Resource Renderer
category: Resource
--- 
# Resource Renderer

The resource changes from the state to presentation. For example the user page saves all of the information about a user in properties, however this is expressed to the client as HTML.

It is the resource renderer that converts it from the state to the presentation. Rendering occurs when renderer resolves the resource as a string. In many cases the rendering is carried out by the template engine which is injected into the renderer.

## Injecting the Renderer 

It is the responsibility of the resources internal resource renderer to display the resource state. It is not the user. In MVC terms, this is like if inside a model there is a renderer that decides how the model should be displayed. 

The renderer is injected using `Dependency Injection`. In the application module you can set the DI configuration to use an alternative renderer. For example when you are in development the `DevRenderer` which displays detailed development information will be injected.
When creating a Web API for example a `JsonRenderer` which renders JSON or a format renderer that outputs JSON and link information [HAL](http://stateless.co/hal_specification.html) (JSON+HAL) can be setup in the DI Settings.

In the `DevModule` which is used for development the resource renderer interface is bound to the `DevRenderer` for development use. By changing this binding you can change every resource to output JSON data for a Web API.
```
$this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\DevRenderer');
```

## Rendering 
The renderer grabs hold of the resource state as a `ResourceObject`, then uses the injected template engine to turn this into a string.

```
public function render(ResourceObject $ro)
{
 ....
 return $ro->body;
}
```

 Note: It is set up so that the resource object does not directly setup the template inside the resource request method. The renderer which indirectly holds the state of the resource (eg: Failed Login), or even view template decides based on that which template is used. So that the model is not concerned by the view, we make sure that the resource does not know any details about the rendering.