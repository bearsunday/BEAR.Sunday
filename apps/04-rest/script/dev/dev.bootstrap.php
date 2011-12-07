<?php

namespace restWorld;

/**
 * App boot
 *
 * Required to set: $appName, $appPath
 *
 * @packate BEAR.hellowolrd
 *
 */
// app define
$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(dirname(__DIR__))));
$appPath  = dirname(dirname(__DIR__));
$appStart = microtime(true);

// delete cache
$tmpFiles = glob($appPath . '/tmp/*', GLOB_NOSORT);
@array_map('unlink', $tmpFiles);
include $appPath . '/script/loader/manual_loader.php';
include $appPath . '/script/exceptionHandler/standard_hadnler.php';
include $system . '/packages/BEAR.Framework/script/bootstrap.php';

// end of boot
