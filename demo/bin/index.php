<?php

declare(strict_types=1);

use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\App;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/autoload.php';

$app = (new Injector(new AppModule()))->getInstance(AppInterface::class);
assert($app instanceof App);
try {
    $response = $app->resource->get('page://self/index', ['name' => 'BEAR.Sunday']);
    /** @var array<string, string> $_SERVER */
    $response->transfer($app->responder, $_SERVER);
} catch (Throwable $e) {
    error_log((string) $e);
    exit(1);
}
