<?php
/**
 * App boot
 *
 * Required to set: $appName, $appPath
 *
 * @packate BEAR.hellowolrd
 *
 */
namespace helloWorld;

// set
$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

// delete cache
$tmpFiles = glob($appPath . '/tmp/resource/%%RES%%*');
array_map('unlink', $tmpFiles);

//load
include __DIR__ . '/loader.php';
include $system . '/packages/BEAR.Framework/script/bootstrap.php';