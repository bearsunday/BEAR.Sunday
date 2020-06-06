<?php

declare(strict_types=1);
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\App;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
assert($app instanceof App);
try {
    $response = $app->resource->get('page://self/index', ['name' => 'BEAR.Sunday']);
    assert($response instanceof ResourceObject);
    $response->transfer($app->responder, $_SERVER);
} catch (\Exception $e) {
    error_log((string) $e);
    exit(1);
}
