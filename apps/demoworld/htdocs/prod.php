<?php

namespace demoworld;

use BEAR\Framework\Dispatcher;

/**
 * Web root for prodcution
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

// Init
include dirname(__DIR__) . '/scripts/exception_handler/standard_handler.php';

// Load
require dirname(__DIR__) . '/scripts/auto_loader.php';

// Route
list($method, $pageUri, $query) = require $appPath . '/scripts/router/standard_router.php';

// Dispatch
list($resource, $page) = (new Dispatcher(new App(__NAMESPACE__)))->getInstance($pageUri);

// Request
$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();

// Output
include $appPath . '/scripts/output/prod.output.php';
