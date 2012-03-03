<?php
namespace demoworld;

use BEAR\Framework\Dispatcher;

/**
 * Web script for prodcution use.
 *
 * @package BEAR.Framework
 *
 * @global string               $method   Resource method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
 */
// Init
if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

include dirname(__DIR__) . '/scripts/exception_handler/prod_handler.php';
ob_start();

// Load
require dirname(__DIR__) . '/scripts/auto_loader.php';

// Route
$route = require dirname(__DIR__) . '/scripts/router/standard_router.php';
list($method, $pagePath, $query) = $route->match($GLOBALS);

// Request
$resource = require dirname(__DIR__). '/scripts/resource.php';
$response = $resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->linkSelf('view')->eager->request();

// Output
include $appPath . '/scripts/output/prod.output.php';
