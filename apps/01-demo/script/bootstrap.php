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
namespace demoWorld;

if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}
$appName = __NAMESPACE__;
$appPath  = dirname(__DIR__);

require $appPath . '/src.php';
require $appPath . '/script/exception_handler/standard_handler.php';
require dirname(dirname(dirname(__DIR__))) . '/packages/BEAR.Framework/script/bootstrap.php';
