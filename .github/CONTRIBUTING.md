# CONTRIBUTING

## Code Contributions

## Installation

Install project dependencies and test tools by running the following commands.

```bash
$ composer install
```

## Running tests

```bash
$ composer test
```
```bash
$ composer coverage // xdebug
$ composer pcov     // pcov
```

Add tests for your new code ensuring that you have 100% code coverage.
In rare cases, code may be excluded from test coverage using `@codeCoverageIgnore`.

## Sending a pull request

To ensure your PHP code changes pass the CI checks, make sure to run all the same checks before submitting a PR.

```bash
$ composer tests
```

When you make a pull request, the tests will automatically be run again by GH action on multiple php versions.
