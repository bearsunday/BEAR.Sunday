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
if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

include dirname(__DIR__) . '/script/dev.bootstrap.php';

$response = $resource->$method->object($page)->linkSelf('view')->eager->request();

include dirname(__DIR__) . '/script/output/dev.output.php';