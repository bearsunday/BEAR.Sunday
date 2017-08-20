<?php
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);
ini_set('xdebug.max_nesting_level', 300);

// loader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/* @var $loader \Composer\Autoload\ClassLoader */
$loader->addPsr4('BEAR\Sunday\\', [__DIR__, __DIR__ . '/Fake']);
$loader->addPsr4('FakeVendor\HelloWorld\\', __DIR__ . '/Fake/Apps/FakeVendor/HelloWorld');
$loader->addPsr4('FakeVendor\HelloWorldX\\', __DIR__ . '/Fake/Apps/FakeVendor/HelloWorldX');
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$_ENV['TMP_DIR'] = __DIR__ . '/tmp';
