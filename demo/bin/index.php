<?php

declare(strict_types=1);
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Application\AbstractApp;
use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
/* @var AbstractApp $app */
try {
    $response = $app->resource->get('page://self/index', ['name' => 'BEAR.Sunday']);
    /* @var ResourceObject $response */
    $response->transfer($app->responder, $_SERVER);
} catch (\Exception $e) {
    error_log((string) $e);
    exit(1);
}
