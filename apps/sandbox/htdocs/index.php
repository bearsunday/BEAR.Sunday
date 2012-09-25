<?php
/**
 * Web server script (Production)
 *
 * @package BEAR.Framework
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\Router\Router;

// profiler
$system = dirname(dirname(dirname(__DIR__)));
//require $system . '/scripts/profile.php';

// load
require $system . '/src/BEAR/Framework/Framework.php';
require dirname(__DIR__) . '/App.php';
require_once $system . '/vendor/smarty/smarty/distribution/libs/Smarty.class.php';

// App instance (init)
$app = App::factory(App::RUN_MODE_PROD, true);

// Route
$router = new Router; // page controller only.
// $router = dirname(__DIR__) . '/scripts/router/standard_router.php'

// Dispatch
$globals = $GLOBALS;
list($method, $pagePath, $query) = $router->match($globals);

// Request
try {
    $page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
} catch (\Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
    error_log((string) $e);
}

// Transfer
$app->response->setResource($page)->render()->prepare()->send();
exit(0);
