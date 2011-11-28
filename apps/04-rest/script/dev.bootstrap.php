<?php

/**
 * App boot
 *
 * Required to set: $appName, $appPath
 *
 * @packate BEAR.hellowolrd
 *
 */

// app define
$appStart = microtime(true);
$appName = 'helloWorld';
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

// delete cache
$tmpFiles = glob($appPath . '/tmp/%%RES%%*');
array_map('unlink', $tmpFiles);

include __DIR__ . '/loader.php';
include __DIR__ . '/exceptionHandler.php';
include $system . '/packages/BEAR.Framework/script/bootstrap.php';