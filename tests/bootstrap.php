<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);

ob_start(); // to hide chekcer message
$isInstallOk = require dirname(__DIR__) . '/scripts/check_env.php';
if (! $isInstallOk) {
    echo "Please fix the install problem before tests." . PHP_EOL;
    exit(1);
}
ob_end_clean();

// loader

require dirname(__DIR__) . '/vendor/autoload.php';
require 'PHPUnit/Extensions/Database/TestCase.php';
$system = dirname(__DIR__);
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di\\', $system . '/vendor/ray/di/src');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation\\', $system . '/vendor/bear/resource/src/');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Sunday\Annotation\\', $system . '/src/');
