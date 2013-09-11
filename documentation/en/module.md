---
layout: default
title: BEAR.Sunday | Module
category: DI & AOP
---
# Module

A module is a collection of DI and AOP binding settings. Object abstracts,interfaces or abstraction classes and implementation, actual classes or factory bindings, methods and their cross-cutting behaviors, to sum up a collection of aspect bindings. We bind the class to the interface in the DI settings. We bind the interceptor to of a particular AOP methods.


The module decides according to the binding collection how objects are built and used. The injector uses the module and creates the object. In the bound interceptor facilitates being able to use the methods of that object.

For example in the `API Module` the JSON export class is bound to the export interface and so the output is JSON. Be careful that the behavior of the output object depending on the mode *is not changed*. The behavior is not changed according to the mode, depending on the mode the configuration of the the object is changed.

Depending to the changes Bear Sunday opens, towards revisions closes according to [(OCP)](http://d.hatena.ne.jp/asakichy/20090126/1232979830).

## DSL Bindings 

Module inherits from `AbstractModule`, the binding DSL inside the `configure` method is bound with however the injection point annotated with `@Inject` provides an instance.

## Binding Type 

Inside the `configure` method of the module that inherits `AbstractModule` binds the however the injection point annotated with `@Inject` provides an instance.
There are many ways of providing an instance:
* Specify a class with no arguments `Linked Binding`.
* Binding using a name `"Named" Binding`.
* Use a custom factory called a provider - `Provider Bindings` etc.

# Binding 

## Linked Binding 

The interface name and class name binding.

```
$this->bind('TransactionLog')->to('DatabaseTransactionLog');
```

Most simply this is a very general method.
Be warned that you can't pass parameters into the constructor.
As below an instance created by `new DatabaseTransactionLog();` is injected into the
`TransactionLog` interface that is flagged by annotation `@Inject`.

_Consumer（The injected side）_
```
/**
 * @Inject
 */
public function setLog(TransactionLog $log)
```

## "Named" Binding 

Giving the binding a name.

```
 $this->bind('CreditCardProcessor')->annotatedWith('Checkout')->to('CheckoutCreditCardProcessor');
```
_Consumer_

```
/**
 * @Inject
 * @Named("serceret_key")
 */
public function setProcessor(CreditCardProcessor $processor)
```

The binding to the scaler type to which there is no interface will be needed to be assigned with a name in the annotation `@Named`.


```
 $this->bind()->annotatedWith('secret_key')->toInstance(1234);
```

_Consumer_
```
/**
 * @Inject
 * @Named("serceret_key")
 */
public function setKey($stringKey)
```

## Instance Bindings 

Binding the instance itself. This is not just class instances that are made with the `new` keyword.
Integers and strings are also included.
Instance bindings even though they are bindings that should avoid it can use bindings of other methods. 
Unlike other bind() methods instances that are not actually used are also created.

```
$this->bind()->annotatedWith("login_timeout_seconds")->toInstance(10);
```

## Provider Bindings 

Parameters needed for object construction or when object construction is complicated you can bind a factory class called a provider.
The provider returns the an instance of the get method that implements the `provider` interface.

```  
$this->bind('TransactionLog')->toProvider('DatabaseTransactionLogProvider');

```

※ The TransactionLog interface is bound to the DatabaseTransactionLogProviderget provider.
At the timing of this injection the get method is called and the instance is retrieved.


## Constructor Bindings 

The constructor binding is a binding that is for injecting 3rd party classes (except BEAR.Sunday and the Application)
which have injection points not marked with `@Inject`

This takes constructor variable names, specifies them as injection points and binds them.

```
$this->bind('TransactionLog')->toConstructor(['db' => new Database]);
```

## Scope 

In order to specify an object as a singleton there are 2 ways.
The first is set an annotation on the class, the second is to specify it at bind time.

```
/**
 * @Scope(Scope::SINGLETON)
 */
public class InMemoryTransactionLog implements TransactionLog
{
}
```

```
$this->bind('TransactionLog')->to('InMemoryTransactionLog')->in(Scope::Singleton);
```

## Ray.DI 

Please take a look at the [http://code.google.com/p/rayphp/wiki/Bindings Ray.Di Ray.Di] Manual that BEAR.Sunday uses for it's DI Framework.