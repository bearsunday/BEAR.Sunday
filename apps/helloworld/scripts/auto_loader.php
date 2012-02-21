<?php

namespace helloworld;

use \Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Auto Loader using Aura.Autoload.
 *
 * @package    hellowolrd
 * @subpackage script
 */
$appPath = dirname(__DIR__);
$system = dirname(dirname($appPath));
$loader = require  $system . '/vendor/Aura.Autoload/scripts/instance.php';
$loader->setPaths([
    __NAMESPACE__ . '\\' => dirname($appPath),
    'BEAR\Framework\\' => $system . '/package/BEAR.Framework/src/',
    'BEAR\Resource\\' => $system . '/vendor/BEAR.Resource/src',
    'Ray\\' => [
        $system . '/vendor/Ray.Aop/src/',
        $system . '/vendor/Ray.Di/src/'
    ],
    'Aura\\' => [
        $system . '/vendor/Aura.Router/src/',
        $system . '/vendor/Aura.Signal/src/',
        $system . '/vendor/Aura.Web/src/'
    ],
    'Doctrine\Common\\' => $system . '/vendor/Doctrine/lib/',
    'Symfony\Component\\' => $system . '/vendor/Symfony/src/',
]);
$loader->register();
AnnotationRegistry::registerAutoloadNamespace("Ray\Di\Di", $system . '/vendor/Ray.Di/src/');