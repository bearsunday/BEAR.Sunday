<?php
/**
 * App boot
 *
 * @packate BEAR.hellowolrd
 *
 * @global $appName application name
 * @global $appPath application root path
 */
namespace restWorld;

// app boot
$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);

require $appPath . '/src.php';
require dirname(dirname(dirname(__DIR__))) . '/packages/BEAR.Framework/script/bootstrap.php';

include $appPath . '/script/dev_utility/clear_cache.php';
include $appPath . '/script/exception_handler/standard_handler.php';