# Changelog

## [1.9.0]

### Added

- `CompileStepInterface` — vocabulary for the compile phase, so renderer modules (madapaja/twig-module, bear/qiq-module) can contribute compile work
- CI / static analysis workflows now run on PHP 8.5

### Changed

- Minimum `bear/resource` requirement is now `^1.33`
- `JsonSchemaRequestException` is normalised to 400 Bad Request in `ThrowableHandler` instead of falling through to 500

### Removed

- `VndError::$headers` and `VndError::$body` public properties — never read or written by the framework; the error response lives in the internal `ErrorPage`

## [1.8.0] - 2025-11-11

This release modernizes the framework by transitioning from the abandoned `doctrine/annotations` package to native PHP 8 attributes, while increasing the minimum PHP requirement to 8.2.

### Major Updates

- Migrated entirely to PHP 8 attributes, eliminating dependency on doctrine annotations
- Raised minimum PHP version requirement from 8.1 to 8.2
- Added PHP 8.5 support in CI workflow
- Moved static analysis tools to `vendor-bin/tools` for better PHP 8.5 compatibility
- Enhanced type safety by fixing all Psalm and PHPStan errors
- Updated Scrutinizer config for PHP 8.4 and jammy image

### Improvements

- Added `#[Override]` attributes to all overridden methods
- Made module and exception classes final for stricter inheritance control
- Normalized schemeHost in WebRouter to prevent double slashes
- Preserved exception chain when converting Error to ErrorException
- Added `symfony/polyfill-php83` for PHP 8.3 feature support

### Removed

- `doctrine/annotations` (officially abandoned)
- `doctrine/cache` (officially abandoned)
- `doctrine/coding-standard`, `phpmd`, `phpmetrics`, `phpstan`, `psalm`, `rector` from main composer.json (moved to vendor-bin/tools)
- Legacy annotation imports and PHPDoc metadata

### Fixed

- Removed unused exception variables in demo code
- Updated static analysis configurations (psalm.xml, phpstan.neon)

## [1.7.0] - 2022-11-29

PHP 7.4 reached EOL (28 Nov 2022) and this package now supports PHP 8.0 and above.

- PHP 8.2 support (https://github.com/bearsunday/BEAR.Sunday/pull/170)
- Drop PHP 7.4 support and optimize for PHP 8 (https://github.com/bearsunday/BEAR.Sunday/pull/171)

## [1.6.1] - 2022-03-27

- Support psr/log 2 and 3 (https://github.com/bearsunday/BEAR.Sunday/pull/167)
- Update Attribute::TARGET for DefaultSchemeHost (https://github.com/bearsunday/BEAR.Sunday/pull/168)
- Document the public bindings provided by modules (https://github.com/bearsunday/BEAR.Sunday/pull/169)

## [1.6.0] - 2022-01-11

## [1.5.5] - 2021-07-15
