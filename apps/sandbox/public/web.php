<?php

namespace Sandbox;

use BEAR\Sunday\Router\Router;
use BEAR\Sunday\Framework\Globals;
use BEAR\Sunday\Framework;
use Exception;

$system = dirname(dirname(dirname(__DIR__)));

/**
 * CLI / Built-in web server script for development
 *
 * examaple:
 *
 * CLI:
 * $ php web.php get /hello
 *
 * Built-in web server:
 *
 * $ php -S localhost:8080 dev.web/php
 *
 * type URL:
 *   http://localhost:8080/hello
 *   http://localhost:8080/helloresource
 *
 * @global $runMode  run mode
 * @global $useCache
 *
 * @package BEAR.Framework
*/

// loader
$isStaticFile = (PHP_SAPI == 'cli-server' && preg_match('/\.(?:png|jpg|jpeg|gif|js|css|ico)$/', $_SERVER["REQUEST_URI"]));
if ($isStaticFile) {
    return false;
}
require_once $system . '/scripts/min_loader.php';
require_once $system . '/scripts/debug_loader.php';
require_once dirname(__DIR__) . '/App.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// run mode
$runMode = App::RUN_MODE_DEV;
$useCache = false;
error_log('run:' . __NAMESPACE__ . " mode={$runMode} cahce=" . ($useCache ? 'enable' : 'disable'));

// Application
$app = App::factory($runMode, $useCache);

// Log
$app->logger->register($app);

// Route
$globals = (PHP_SAPI === 'cli') ? new Globals($argv) : $GLOBALS;
// or use router
// $router = require dirname(__DIR__) . '/scripts/router/standard_router.php';
$router = new Router;

// Dispatch
list($method, $pagePath, $query) = $router->match($globals);

// Request
try {
    $page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
} catch (Exception $e) {
    $page = $app->exceptionHandler->handle($e);
    //$page = $app->exceptionHandler->handle($e)->bePage();
}

// Transfer
$app->response->setResource($page)->render()->prepare()->outputWebConsoleLog()->send();
exit(0);
