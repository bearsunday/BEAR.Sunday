<?php
namespace helloworld;

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
$loader = require  $system . '/vendor/Aura/Autoload/scripts/instance.php';
$namespaces = require  $system . '/vendor' . DIRECTORY_SEPARATOR . '.composer/autoload_namespaces.php';
$namespaces += [
    __NAMESPACE__ . '\\' => dirname($appPath),
    'BEAR\Framework\\' => $system . '/package/BEAR/Framework/src/'
];
$loader->setPaths($namespaces);
$loader->register();
// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di', $system . '/vendor/Ray/Di/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation', $system . '/vendor/BEAR/Resource/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation', $system . '/package/BEAR/Framework/src/');
