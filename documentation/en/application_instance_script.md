---
layout: default
title: BEAR.Sunday | Application Instance Script
category: Application
---
# Application Instance Script

The instance script is a script that creates the application instance. It also runs the configuration for class autoloader which is needed by the application.

# Instance Creation 

The section of code that applies to the instance script is below.

```
$injector = Injector::create([new ProdModule]);
$app = $injector->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
```

The `ProdModule` is a type of [module module], for each application mode there is specific build information (DI and AOP settings).

It is then built up with application class names and with modules. The injector retrieves the application object set by the application context interface bound by the application class.

## Instance Retrieval Reuse 

The cost of retrieving the application object is huge.

Syntax analysis of the original PHP script in order to resolve the annotation names set in the the module, DI injection, AOP method interceptor bindings in order to cut the cost of all of these in the production environment the application object is cached inside this instance script and reused.

## Performance 

At bootstrap time annotation resolution, DI and AOP binding cost becomes virtually zero.                                     
In BEAR.Sunday a very flexible architecture is possible by having many abstraction layers, but due to this reuse there is minimal performance impact with maximum flexibility and performance both being met.

Also the service components used by the application are guaranteed not to change on each request, delivering a more stable software quality. 