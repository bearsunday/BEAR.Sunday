<?php
/**
 * App boot
 *
 * @packate BEAR.hellowolrd
 *
 * @global $appName
 * @global $appPath
 * @global $system
 */
namespace restWorld;

// app boot
$appStart = microtime(true);
$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

include __DIR__ . 'loader/auto_loader.php';
include __DIR__ . 'exceptionHandler/dev.php';
// system boot
include $system . '/packages/BEAR.Framework/script/bootstrap.php';

// end of boot