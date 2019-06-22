![Logo](http://bearsunday.github.io/images/screen/BEAR_logo.png)

# BEAR.Sunday

## A resource-oriented application framework

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/?branch=1.x
)
[![Code Coverage](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/bearsunday/BEAR.Sunday/?branch=1.x
)
[![Build Status](https://travis-ci.org/bearsunday/BEAR.Sunday.svg?branch=1.x
)](https://travis-ci.org/bearsunday/BEAR.Sunday)

## What's BEAR.Sunday

This resource orientated framework has both externally and internally
 a **REST centric architecture**,  implementing **Dependency Injection** and
**Aspect Orientated Programming** heavily to offer you surprising
simplicity,  order and flexibility in your application. With very
 few components of its own, it is a fantastic example of how a framework
 can be built using  existing components and libraries from other
frameworks, yet offer even further benefit and beauty.

## Everything is a resource

In BEAR.Sunday **everything is a REST resource** which leads to far simpler design and extensibility.
Interactions with your database, services and even pages and sections of your app all sit comfortably in a resource which can be consumed or rendered at will.

## Documentation

 * [http://bearsunday.github.io/](http://bearsunday.github.io/)

## About this package

This is the framework core interface package that contains a basic reference implementation.

```
src/
├── Annotation
├── Exception
├── Extension -- Framework extension interface
│   ├── Application
│   ├── Error
│   ├── ExtensionInterface.php
│   ├── Router
│   └── Transfer
├── Inject -- Setter trait
├── Module -- Unchangeble module by context
│   ├── Annotation
│   ├── Cache
│   ├── Constant
│   ├── Resource
│   └── SundayModule.php -- Root module of this package
└── Provide  -- Changeable module by context and refference implementations
    ├── Application
    ├── Error
    ├── Representation
    ├── Router
    └── Transfer
```

## Related project

 * [Ray.Di](https://github.com/ray-di/Ray.Di) - dpendency injection framework
 * [Ray.Aop](https://github.com/ray-di/Ray.Di) - aspect oriented framework
 * [BEAR.Resource](https://github.com/bearsunday/BEAR.Resource) - hypermedia framework for object as a service
 * [BEAR.Package](https://github.com/bearsunday/BEAR.Package) - web application framework
 * [BEAR.Skeleton](https://github.com/bearsunday/BEAR.Skeleton) - project skeleton

<img src="http://bearsunday.github.io/BEAR.Sunday/framework_structure.png" width="400">
