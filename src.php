<?php

use \Symfony\Component\ClassLoader\UniversalClassLoader as ClassLoader;

// vendor/* loader
require __DIR__ . '/vendor/Symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
// require __DIR__ . '/vendor/Ray.Aop/src.php';
// require __DIR__ . '/vendor/Ray.Di/src.php';
// require __DIR__ . '/vendor/BEAR.Resource/src.php';
// require __DIR__ . '/vendor/Smarty3/libs/Smarty.class.php';
// require __DIR__ . '/vendor/Haanga/lib/Haanga.php';
// require __DIR__ . '/vendor/Aura.Router/src.php';
// require __DIR__ . '/vendor/Aura.Signal/src.php';
require __DIR__ . '/vendor/Twig/lib/Twig/Environment.php';

$namespaces = array(
    'Guzzle' => __DIR__ . '/vendor/Guzzle/src',
    'Symfony' => __DIR__ . '/vendor/Symfony/src',
    'Monolog' => __DIR__ . '/vendor/Monolog/src',
    'Doctrine\Common' => __DIR__ . '/vendor/Doctrine/lib',
    'Doctrine\DBAL' => __DIR__ . '/vendor/Doctrine.Dbal/lib',
    'Monolog' => __DIR__ . '/vendor/Monolog/src',
);

$classLoader = new ClassLoader;
$classLoader->registerNamespaces($namespaces);
$classLoader->registerPrefix('Zend_', __DIR__ . '/vendor');
$classLoader->registerPrefix('Twig_', __DIR__ . '/vendor/Twig/lib');
$classLoader->register();

// BEAR.Framework loader
require __DIR__ . '/package/BEAR.Framework/src.php';
