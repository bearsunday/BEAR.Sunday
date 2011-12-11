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
$appPath = dirname(__DIR__);

require $appPath . '/src.php';
require $appPath . '/script/dev_tools/clear_cache.php';
require $appPath . '/script/exception_handler/standard_handler.php';
require dirname(dirname(dirname(__DIR__))) . '/packages/BEAR.Framework/script/bootstrap.php';
// end of boot