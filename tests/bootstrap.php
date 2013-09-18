<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);
ini_set('xdebug.max_nesting_level', 300);

// loader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
$loader->add('BEAR\Sunday' , __DIR__);

$GLOBALS['TEST_TMP'] = __DIR__ . '/tmp';