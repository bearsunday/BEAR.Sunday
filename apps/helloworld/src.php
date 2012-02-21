<?php

namespace demoworld;
/**
 * Include
 *
 * @package    hellowolrd
 * @subpackage script
 *
 * @return  Ray\Di\InjectorInterface
 */

$system = dirname(dirname(__DIR__));
require_once $system . '/vendor/Symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once $system . '/vendor/Symfony/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php';

use Symfony\Component\ClassLoader\ApcUniversalClassLoader as ClassLoader;

// vendor/* loader
require_once $system . '/vendor/Ray.Aop/src.php';
require_once $system . '/vendor/Ray.Di/src.php';
require_once $system . '/vendor/BEAR.Resource/src.php';
require_once $system . '/package/BEAR.Framework/src.php';
// require_once $system . '/vendor/Aura.Router/src.php';
// require_once $system . '/vendor/Aura.Signal/src.php';
// require_once $system . '/vendor/Smarty3/libs/Smarty.class.php';
// require_once $system . '/vendor/Haanga/lib/Haanga.php';
// require_once $system . '/vendor/Aura.Router/src.php';
// require_once $system . '/vendor/Aura.Signal/src.php';
// require_once $system . '/vendor/Twig/lib/Twig/Environment.php';
$namespaces = [
           'helloworld' => __DIR__ . '/'    ,
           'Doctrine\Common' => $system . '/vendor/Doctrine/lib/',
           'Aura\Signal' => $system . '/vendor/Aura.Signal/src/',
//         'Guzzle' => $system . '/vendor/Guzzle/src',
//         'Symfony' => $system . '/vendor/Symfony/src',
//         'Monolog' => $system . '/vendor/Monolog/src',
//         'Doctrine\DBAL' => $system . '/vendor/Doctrine-DBAL/lib',
];
$classLoader = new ClassLoader(__NAMESPACE__);
$classLoader->registerNamespaces($namespaces);
// $classLoader->registerPrefix('Zend_', $system . '/vendor');
$classLoader->register();
// BEAR.Framework loader
require_once __DIR__ . '/Module/AppModule.php';
require_once __DIR__ . '/Module/SchemeCollectionProvider.php';
require_once __DIR__ . '/Page/Hello.php';
