<?php
/**
 * App boot
 *
 * @packate BEAR.hellowolrd
 *
 * @global $appName application name
 * @global $appPath application root path
 * @global $system  system root path
 *
 */
namespace restWorld;

// app boot
$appStart = microtime(true);
$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

// delete cacheå
$tmpFiles = glob($appPath . '/tmp/*', GLOB_NOSORT);
@array_map('unlink', $tmpFiles);

require $appPath . '/script/loader/manual_loader.php';
require $appPath . '/script/exception_handler/standard_handler.php';
require $system . '/packages/BEAR.Framework/script/bootstrap.php';

// end of boot