<?php

/**
 * Auto Loader using Aura.Autoload.
 *
 * @package    hellowolrd
 * @subpackage script
 */
$appPath = dirname((__DIR__));
$system = dirname(dirname($appPath));
$loader = require  $system . '/vendor/Aura.Autoload/scripts/instance.php';
$loader->setPaths([
    'BEAR\Resource\\' => $system . '/vendor/BEAR.Resource/src',
    'Ray\\' => [
        $system . '/vendor/Ray.Aop/src/',
        $system . '/vendor/Ray.Di/src/'
    ],
    'BEAR\Framework\\' => $system . '/package/BEAR.Framework/src/',
    'Doctrine\Common\\' => $system . '/vendor/Doctrine/lib/',
    'helloWorld\\' => dirname($appPath),
    'Symfony\Component\\' => $system . '/vendor/Symfony/src/',
    'Aura\\' => [
        $system . '/vendor/Aura.Router/src/',
        $system . '/vendor/Aura.Signal/src/',
        $system . '/vendor/Aura.Web/src/'
        ],
    ['Zend_'=> $system . '/vendoro/zend/library']
]);
$loader->register();
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("Ray\Di\Di", $system . '/vendor/Ray.Di/src/');

