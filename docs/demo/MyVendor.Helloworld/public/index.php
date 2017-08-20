<?php
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
use BEAR\Sunday\Extension\Application\AbstractApp;
use BEAR\Sunday\Extension\Application\AppInterface;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader('class_exists');

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
/* @var $app AbstractApp */
$request = $app->router->match($GLOBALS, $_SERVER);
try {
    $page = $app
        ->resource
        ->{$request->method}
        ->uri($request->path)($request->query)
        ->transfer($app->responder, $_SERVER);
} catch (\Exception $e) {
    error_log($e);
    exit(1);
}
