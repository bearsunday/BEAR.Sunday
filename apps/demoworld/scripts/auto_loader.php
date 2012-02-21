<?php
namespace demoworld;

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
    'helloworld' . '\\' => dirname($appPath),
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
    'Guzzle\\' => $system . '/vendor/Guzzle/src/',
    'Haanga_' => $system . '/vendor/Haanga/lib/',
    'Twig_' => $system . '/vendor/Twig/lib/',
    'smarty_' => $system . '/vendor/Smarty3/libs/sysplugins/',
]);
require_once $system .  '/vendor/Smarty3/libs/Smarty.class.php';
$loader->register();

// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace("Ray\Di\Di", $system . '/vendor/Ray.Di/src/');
AnnotationRegistry::registerAutoloadNamespace("BEAR\Resource\Annotation", $system . '/vendor/BEAR.Resource/src/');
AnnotationRegistry::registerAutoloadNamespace("demoworld\Annotation", dirname($appPath));
