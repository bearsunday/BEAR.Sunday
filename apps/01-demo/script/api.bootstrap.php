<?php
/**
 * App boot
 *
 * @packate BEAR.hellowolrd
 *
 * @global $appName application name
 * @global $appPath application root path
 */
namespace demoWorld;

// app boot
$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);

require $appPath . '/src.php';
require dirname(dirname(dirname(__DIR__))) . '/packages/BEAR.Framework/script/api.bootstrap.php';

// include $appPath . '/script/utility/clear_cache.php';
include $appPath . '/script/exception_handler/standard_handler.php';