<?php
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
use BEAR\Sunday\Extension\Application\AppInterface;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

/* @var $loader ClassLoader*/
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
try {
    $page = $app
        ->resource
        ->get
        ->uri('page://self/index')(['name' => 'BEAR.Sunday'])
        ->transfer($app->responder, $_SERVER);
} catch (\Exception $e) {
    error_log($e);
    exit(1);
}
