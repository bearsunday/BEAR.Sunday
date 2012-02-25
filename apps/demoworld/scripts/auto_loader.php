<?php
namespace demoworld;

use \Doctrine\Common\Annotations\AnnotationRegistry;
use Aura\Autoload\Loader;

/**
 * Auto Loader using Aura.Autoload.
 *
 * @package    hellowolrd
 * @subpackage script
 */


$appPath = dirname(__DIR__);
$system = dirname(dirname($appPath));

include $system . '/package/BEAR.Framework/scripts/core_loader.php';
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
    'Doctrine\\' => [
        $system . '/vendor/Doctrine.Common/lib/',
        $system . '/vendor/Doctrine.Dbal/lib/',
    ],
    'Symfony\Component\\' => $system . '/vendor/Symfony/src/',
    'Guzzle\\' => $system . '/vendor/Guzzle/src/',
    'Haanga_' => $system . '/vendor/Haanga/lib/',
    'Twig_' => $system . '/vendor/Twig/lib/',
]);
$loader->register();
// $loader->setMode(Loader::MODE_SILENT);

// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di', $system . '/vendor/Ray.Di/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation', $system . '/vendor/BEAR.Resource/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation', $system . '/package/BEAR.Framework/src/');
AnnotationRegistry::registerAutoloadNamespace(__NAMESPACE__ . '\Annotation', dirname($appPath));