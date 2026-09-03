# Changelog

## [Unreleased]

- Deprecate `ResourceInject`; use constructor injection instead — automated migration: https://github.com/bearsunday/rector-bearsunday

## [1.9.0]

- Add CompileStepInterface — compile-phase vocabulary for renderer modules; madapaja/twig-module and bear/qiq-module are waiting on this release
- Handle JsonSchemaRequestException as 400 Bad Request in ThrowableHandler; schema validation failure is a client error, not a 500
- Require bear/resource ^1.33 for the JsonSchema exceptions
- Remove dead public properties VndError::$headers / $body — the error response lives in the internal ErrorPage (BC break for code reading them)
- CI on PHP 8.5

## [1.8.0] - 2025-11-11

- Migrate from the abandoned doctrine/annotations and doctrine/cache to native PHP 8 attributes
- Require PHP 8.2
- Move static analysis tools to vendor-bin/tools for PHP 8.5 compatibility
- Add #[Override] attributes; make module and exception classes final
- No migration steps required — all changes are internal

## [1.7.0] - 2022-11-29

PHP 7.4 reached EOL (28 Nov 2022); this package supports PHP 8.0 and above.

- PHP 8.2 support https://github.com/bearsunday/BEAR.Sunday/pull/170
- Drop PHP 7.4 support and optimize for PHP 8 https://github.com/bearsunday/BEAR.Sunday/pull/171

## [1.6.1] - 2022-03-27

- Support psr/log 2 and 3 https://github.com/bearsunday/BEAR.Sunday/pull/167
- Update Attribute::TARGET for DefaultSchemeHost https://github.com/bearsunday/BEAR.Sunday/pull/168
- Document the public bindings provided by modules https://github.com/bearsunday/BEAR.Sunday/pull/169

## [1.6.0] - 2022-01-11

- Support PHP 8.1 https://github.com/bearsunday/BEAR.Sunday/pull/159
- Drop deprecated PHP 7.3 support https://github.com/bearsunday/BEAR.Sunday/pull/163
- Deprecate AbstractApp class https://github.com/bearsunday/BEAR.Sunday/pull/164
- Refactor Router: array-shape type parameters, RouterMatch accepts parameters in constructor

## [1.5.5] - 2021-07-15

- Remove cache https://github.com/bearsunday/BEAR.Sunday/pull/157
- Deprecate `AbstractApp`; use `AppInterface` instead https://github.com/bearsunday/BEAR.Skeleton/blob/1.10.1/src/Module/App.php
