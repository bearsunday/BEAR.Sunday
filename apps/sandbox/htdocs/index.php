<?php
/**
 * Web server script (Production USE)
 *
 * @package BEAR.Framework
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Framework\Web\HttpFoundation as Output;

// profiler
require dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/scripts/profile.php';
require dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/scripts/core_loader.php';

// load
require dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
require dirname(__DIR__) . '/App.php';

// App instance (init)
$app = App::factory(App::RUN_MODE_PROD);

// Route
$router = new Router; // page controller only.
// $router = dirname(__DIR__) . '/scripts/router/standard_router.php'

// Dispatch
list($method, $pagePath, $query) = $router->match($GLOBALS);

// Request
$page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();

// Transfer
$app->response->setResource($page)->prepare()->send();