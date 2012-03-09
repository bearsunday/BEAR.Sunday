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

include $system . '/package/BEAR/Framework/scripts/core_loader.php';
$loader = require  $system . '/vendor/Aura/Autoload/scripts/instance.php';
$namespaces = require  $system . '/vendor' . DIRECTORY_SEPARATOR . '.composer/autoload_namespaces.php';
$namespaces += [
    __NAMESPACE__ . '\\' => dirname($appPath),
    'helloworld' . '\\' => dirname($appPath),
    'BEAR\Framework\\' => $system . '/package/BEAR/Framework/src/'
];
$loader->setPaths($namespaces);
$loader->register();
$loader->setMode(Loader::MODE_SILENT);

// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di', $system . '/vendor/Ray.Di/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation', $system . '/vendor/BEAR/Resource/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation', $system . '/package/BEAR/Framework/src/');
AnnotationRegistry::registerAutoloadNamespace(__NAMESPACE__ . '\Annotation', dirname($appPath));
