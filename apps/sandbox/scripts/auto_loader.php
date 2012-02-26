<?php
namespace sandbox;

use \Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Auto Loader using Aura.Autoload.
 *
 * @package    hellowolrd
 * @subpackage script
 *
 * @global $system System path.
 */
$appPath = dirname(__DIR__);
$system = dirname(dirname($appPath));

// load accerarater
include $system . '/package/BEAR.Framework/scripts/core_loader.php';
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
    'Doctrine\\' => [
        $system . '/vendor/Doctrine.Common/lib/',
        $system . '/vendor/Doctrine.Dbal/lib/',
    ],
    'Symfony\Component\\' => $system . '/vendor/Symfony/src/',
    'Guzzle\\' => $system . '/vendor/Guzzle/src/',
    'Haanga_' => $system . '/vendor/Haanga/lib/',
    'Twig_' => $system . '/vendor/Twig/lib/',
    'smarty_' => $system . '/vendor/Smarty3/libs/sysplugins/',
]);
$loader->register();
// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di', $system . '/vendor/Ray.Di/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation', $system . '/vendor/BEAR.Resource/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation', $system . '/package/BEAR.Framework/src/');
