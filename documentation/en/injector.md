---
layout: default
title: BEAR.Sunday | Dependency Injector
category: DI & AOP
---
# Dependency Injector

Objects that are needed within BEAR.Sunday objects are commonly known as dependencies and are expected to be assigned outside of the class. The injector is based on the *module* externally injects the object needed by the dependency, in other words performs the injection.

In BEAR.Sunday's DI ([Ray.Di](http://code.google.com/p/rayphp/wiki/Motivation?tm=6)) the dependency domain and usage domain are cleanly separated. Whether creating an object or using an object there is no rule that says you have to implement 1 class in each.

Just like factories `dependency injection` is a design pattern. The fundamental principle being that the behavior and dependency assignment are cleanly separated.

## Dependency Inversion Principle 

 A. High-level modules should not depend on low-level modules. Both should depend on abstractions.

 B. Abstractions should not depend upon details. Details should depend upon abstractions.

--[http://en.wikipedia.org/wiki/Dependency_inversion_principle Dependency Inversion Principle (DIP)]

All object dependencies are abstractions, in other words make dependencies to interfaces and abstractions which will then be injected.

## Object Graph 

In dependency injection an object is received by the constructor. In order for the creation of the object to happen that dependency is needed. However in the dependency there are other dependencies are needed, and then this carries on and on.... So in order to build our object the creation of an object graph is needed. 

In BEAR.Sunday the object graph is created 1 time only upon bootstrap. This is called compiling and this is separate from object runtime behavior.

## Injector Creation 

The injector uses the module and builds as follows.

```
$injector = Inject::create([new AppModule]);
```

The above script is a simplification of the following. So that the injector can manually inject it's own dependencies the injector dependencies are passed to the constructor.
They are both dependent on the interface and can be interchanged.

```
use Ray\Di;

$injector = new Di\Injector(new Di\Container(new Di\Forge(new Di\ApcConfig(new Di\Annotation(new Di\Definition, new AnnotationReader)))), new AppModule);
```


You can set up several modules.

```
$injector = Inject::create([new OneModule, new TwoModule, ...]);
```

* Modules are generally independent of one another. Content bound with `OneModule` will not be applied in `TwoModule`.

## Module 

The module binds instance requested by *@Inject* annotated dependencies and the instance retrieval method and performs the injection settings.

The module inherits from `AbstractModule`, in the `configure` method binds the (injection point) and the dependency (also dependency providing method) using binding DSL.

Example) The `CheckoutCreditCardProcessor` is bound to the `CreditCardProcessor` interface.


```
class AppModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('CreditCardProcessor')->to('CheckoutCreditCardProcessor');
    }
}
```

## Module Dependencies 

Inside the modules `configure` method in order to retrieve the dependency some DI is needed.
At that time by using the *requireInjection* method we can perform the injection.

```
$this->bind()->annototatedWith('age')->toInstance(25);
$user = $this->requireInjection('User');
```

An instance of the `User` class is created and 25 is is injected into the `@Named("age")` injection point.


## Installing Modules 

You can also install other modules and combine them into the setup.

```
$this->install(new MySqlModule);
```

Using the configuration from your own module, when you want to retrieve the instance in the module you are installing create and pass the injector to the constructor.

```
$this->bind()->('socket_path')->toInstance('/tmp/mysql.sock');
$this->install(new MySqlModule($this);
```
* Inside the `MySqlModule` module if you add the annotation `@Inject @Named('socket_path')`  `'/tmp/mysql.sock'` will be injected.

## Combining Modules 
In the sandbox application there are 3 modules combined and 1 application configured.

#### `FrameworkModule` 
This is the framework configuration. You are free to switch in your own custom module. If you make a `binding` before installation of this module can switch the classes being using used in the framework.

#### Mode Module (`DevModule`, `ProdModule`...) 
The application configuration for runtime environment. In the sandbox application PROD(Production), DEV(Development), STUB(Stub Data) environments are prepared for you.


#### Application Module(`AppModule`) 
Application configuration not  dependent on you run mode.

You aren't limited to these 3 modules. For example there may be team sharing modules, pattern service sharing modules, custom utility modules etc. Depending on the concern a module can be created and used universally accross the application.