---
layout: default
title: BEAR.Sunday | Application Introduction 
category: Application
---

# Application Introduction 

The application object you create in the bootstrap contains all of the service objects that you need in the application script that describes the application runtime.
All of the objects that you use are packaged up in this object or are created by the packaged factories.

In order to create this object we first need our dependencies. However the included dependencies and 
dependencies to be included in the factories are all finally acquired as an object graph (object mapping)

## Compile and Runtime　

The [module module] is a binding of an object abstract (an interface or abstract class) and the implementation (actual class or factory), and is a collection of bindings to a method and it's cross-cutting behavior.

BEAR.Sunday is based on the `Dependency injection pattern`, in the application object there is clear separation of the construction (compile time) and execution (runtime).
The object is split up into the object performing construction and object performing execution and are not mixed up.

 * On boot depending on the mode (environment) the application object is created. (Compile time)
 * After that the object execution starts. (Runtime)
 * On execution whenever a new object is acquired the `Provider` is used. Outside of this there is no other principles for retrieving objects.

## Construction Reuse 

Objects are only built up 1 single time. The object is based on the module that according to the execution mode dependencies are injected and aspects are weaved to specific methods. So in this kind of retrieving dependencies of dependencies is repeated ending up becoming the final object graph. The fully created object graph is then stored in the APC object container and are reused across requests.

So in a BEAR.Sunday application the constructor starts the services,
at the objects first runtime the compilation only takes place once. From the second time construction is not run the object stored in the container is reused.

## Eager Binding 

Not depending on the application runtime, ensuring that the dependency injection that does not change for each request is complete at compile time.

The configuration that uses the module decides how the object is built, but does not directly decide at the objects runtime.

For example it is not recommended to look at the configuration to change behavior at runtime.

```
// Not recommended
if ($config['debug'] # = true) {
    //For use in debugging
}
```

Instead *at compile time upon checking the configuration bind to an object with different behavior*.
The compile completed object can process just the differences at runtime. So it isn't recommended to have code that assigns strings in every request.

Fore example in the development screen there are tools that you can check the information about many objects, because the development renderer is bound to the rendering interface, the renderer does not check the application mode to change the rendering. The application mode is not a variable that changes runtime behavior when the application is executed, instead according to that mode an object is created.

Each of the objects that build up the `Sandbox` application are not aware of the current execution mode.

## Late Binding 

The dependencies do not change through a request but there are things that can only be decided at runtime. For example, the log object will need to know what kind of request it is, the DB object may need to know what instance （master/slave) is needed depending on the request method, at compile time eager binding is not possible.

Depending on the method, the cut in interceptor solves the problem through a delayed binding of the dependencies. The interceptor can inject the dependencies depending on the context right before the method is run.

The clear separation of eager binding and delayed binding to aim for advanced software quality and performance are features of BEAR.Sunday.