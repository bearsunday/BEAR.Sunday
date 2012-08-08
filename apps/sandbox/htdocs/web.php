<?php

namespace sandbox;

use BEAR\Framework\Router\Router;
use BEAR\Framework\Globals;
use BEAR\Framework\Framework;
use Exception;

$system = dirname(dirname(dirname(__DIR__)));
require_once $system . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
// profiler
require_once dirname(__DIR__) . '/App.php';

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

// route static assets
if (PHP_SAPI == 'cli-server') {
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css|ico)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}
// reroute another PHP file
$doIncludePHPfile = (
    PHP_SAPI !== 'cli' &&
    file_exists($_SERVER['SCRIPT_FILENAME']) &&
    ($_SERVER['SCRIPT_FILENAME'] !== __DIR__ . '/index.php') &&
    ($_SERVER['SCRIPT_FILENAME'] !== __FILE__)
);
if ($doIncludePHPfile) {
    include $_SERVER['SCRIPT_FILENAME'];
    exit(0);
}
require_once $system . '/vendor/smarty/smarty/distribution/libs/Smarty.class.php';
require_once $system . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_lib.php';
require_once $system . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_runs.php';


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
