<?php

require_once __DIR__ . '/vendor/Ray.Aop/src.php';
require_once __DIR__ . '/vendor/Ray.Di/src.php';
require_once __DIR__ . '/vendor/BEAR.Resource/src.php';
require_once __DIR__ . '/vendor/Smarty3/libs/Smarty.class.php';
require_once __DIR__ . '/vendor/Haanga/lib/Haanga.php';
require_once __DIR__ . '/packages/BEAR.Framework/src.php';
require_once __DIR__ . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

// Guzzle
$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader;
$classLoader->registerNamespaces(
    array(
        'Guzzle' => __DIR__ . '/vendor/Guzzle/src/Guzzle',
        'Doctrine' => __DIR__ . '/vendor/Doctrine/lib',
        'Monolog' => __DIR__ . '/vendor/Monolog/src'
    )
);