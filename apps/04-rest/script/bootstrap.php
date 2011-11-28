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

$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

include __DIR__ . '/loader.php';
include __DIR__ . '/exceptionHandler.php';
include $system . '/packages/BEAR.Framework/script/bootstrap.php';