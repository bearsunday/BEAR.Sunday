<?php

namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Framework\Web\HttpFoundation as Output;

/**
 * Web server script (Production USE)
 *
 * @package BEAR.Framework
 */
 if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

// load
apc_clear_cache();
require_once dirname(dirname(dirname(__DIR__))) . '/vendor/smarty/smarty/libs/Smarty.class.php';
require dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
require dirname(__DIR__) . '/App.php';

// Init
$app = App::init();

// Route
$router = new Router; // page controller only.
// $router = dirname(__DIR__) . '/scripts/router/standard_router.php'

// Dispatch
list($method, $pagePath, $query) = $router->match($GLOBALS);

// Request
$page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();

// Transfer
(new Output)->setResource($page)->prepare()->output();