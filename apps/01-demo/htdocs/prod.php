<?php

namespace demoWorld;

use BEAR\Framework\Dispatcher;

/**
 * CLI / Built-in web server script with router
 *
 * @example $ php dev.php get /hello (CLI)
 * @example http://sunday.host/hello (Web)
 *
 * @package BEAR.Framework
 *
 * @global string               $method   Resource method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
 */
if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

// Init
$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);
// include $appPath . '/script/utility/clear_cache.php';
include $appPath . '/script/exception_handler/standard_handler.php';

// Load
require $appPath . '/src.php';

// Route
list($method, $pageUri, $query) = require $appPath . '/script/router/standard_router.php';

// Dispatch
list($resource, $page) = (new Dispatcher($appName, $appPath))->getInstance($pageUri);

// Request
$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();

// Output
require $appPath . '/script/output/prod.output.php';