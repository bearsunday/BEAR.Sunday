<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);

// loader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
$loader->add('BEAR\Sunday' , __DIR__);
