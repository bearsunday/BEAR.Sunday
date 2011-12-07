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

if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}
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