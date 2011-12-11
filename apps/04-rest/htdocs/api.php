<?php
/**
 * CLI / Built-in web server script.
 *
 * @package BEAR.Framework
 *
 * @global string               $method
 * @global BEAR\Resource\Client $resource
 * @global BEAR\Resource\Object $page
 */
use BEAR\Resource\Object as ResourceObject;

if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

// app define
$appName = 'restWorld';
$system = (dirname(dirname(dirname(__DIR__))));
$appPath  = dirname(__DIR__);

// delete cache
$tmpFiles = glob($appPath . '/tmp/*');
@array_map('unlink', $tmpFiles);

include $appPath . '/src.php';
include $appPath . '/script/exception_handler/standard_handler.php';
include $system . '/packages/BEAR.Framework/script/api.bootstrap.php';

$response = $resource->$method->object($ro)->withQuery($query)->eager->request();

if (!($response instanceof ResourceObject)) {
    $ro->body = $response;
    $response = $ro;
}

include $appPath . '/script/output/api.output.php';
