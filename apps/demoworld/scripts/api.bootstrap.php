<?php
/**
 * App boot
 *
 * @packate BEAR.hellowolrd
 *
 * @global $appName application name
 * @global $appPath application root path
 */
namespace demoworld;

// app boot
$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);

require $appPath . '/src.php';
require dirname(dirname(dirname(__DIR__))) . '/packages/BEAR.Framework/scripts/api.bootstrap.php';

include $appPath . '/scripts/utility/clear_cache.php';
include $appPath . '/scripts/exception_handler/standard_handler.php';