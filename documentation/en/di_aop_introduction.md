---
layout: default
title: BEAR.Sunday | Ray.Di Ray.Aop Introduction
category: DI & AOP
---
# Ray.Di Ray.Aop Introduction

BEAR.Sunday uses universally across the framework the Dependency Injection(DI) pattern and Aspect Orientated Programming (AOP).

With the benefit of being able to use annotations to inject dependencies it uses the [Ray](http://code.google.com/p/rayphp/wiki/Motivation?tm=6) DI/AOP framework which is a PHP clone of [http://en.wikipedia.org/wiki/Google_Guice Google Guice].

AOP in BEAR.Sunday uses the interface settled upon by the [http://aopalliance.sourceforge.net/ AOP Alliance] implemented in PHP. Being able to bind multiple cross-cutting concerns to a specific method by using annotations or naming conventions.

In dynamic languages DI/AOP introduction can bring in performance concerns.

However in BEAR.Sunday with loose coupling and a high level of abstraction, using a created object graph in the APC container introduction of DI/AOP has next to no affect on performance. The minimum bootstrap cost is extremely cheap.