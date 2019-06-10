<?php

declare(strict_types=1);
use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\Exception\ResourceNotFoundException;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Application\AbstractApp;
use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
/* @var AbstractApp $app */
$request = $app->router->match($GLOBALS, $_SERVER);
try {
    $response = $app->resource->{$request->method}->uri($request->path)($request->query);
    /* @var ResourceObject $response */
    $response->transfer($app->responder, $_SERVER);
} catch (ResourceNotFoundException $e) {
    http_response_code(404);
    echo 'Not found' . PHP_EOL;
} catch (BadRequestException $e) {
    http_response_code(400);
    echo 'Bad request' . PHP_EOL;
} catch (\Exception $e) {
    http_response_code(500);
    echo 'Server error' . PHP_EOL;
    error_log((string) $e);
    exit(1);
}

// php -S 127.0.0.1:8088 index.php

//$ curl -i -X DELETE http://127.0.0.1:8088/
//HTTP/1.1 400 Bad Request
//Host: 127.0.0.1:8088
//Date: Wed, 14 Mar 2018 01:10:39 +0100
//Connection: close
//X-Powered-By: PHP/7.1.10
//Content-type: text/html; charset=UTF-8
//
//Bad request

//$ curl -i -X GET http://127.0.0.1:8088/abc
//HTTP/1.1 404 Not Found
//Host: 127.0.0.1:8088
//Date: Wed, 14 Mar 2018 01:09:00 +0100
//Connection: close
//Content-type: text/html; charset=UTF-8
//
//Not found

//$ curl -i -X GET http://127.0.0.1:8088/
//HTTP/1.1 200 OK
//Host: 127.0.0.1:8088
//Date: Wed, 14 Mar 2018 01:10:01 +0100
//Connection: close
//content-type: application/json
//
//{
//    "greeting": "Hello World"
//}
