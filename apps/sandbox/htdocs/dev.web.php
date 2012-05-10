<?php

namespace sandbox;

use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Framework\Framework;

require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
require_once dirname(__DIR__) . '/App.php';

/**
 * CLI / Built-in web server dev script
 *
 * examaple:
 *
 * CLI:
 * $ php dev.web.php get /hello
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
// reoute another PHP file
$doIncludePHPfile = (
    PHP_SAPI !== 'cli' &&
    file_exists($_SERVER['SCRIPT_FILENAME']) &&
	($_SERVER['SCRIPT_FILENAME'] !== __DIR__  . '/index.php')
);
if ($doIncludePHPfile) {
	include $_SERVER['SCRIPT_FILENAME'];
	exit(0);
}

// run mode
$runMode = App::RUN_MODE_STAB;
$useCache = false; 
error_log("run: " . __NAMESPACE__ . "mode={$runMode} cahce=" . ($useCache ? 'enable' : 'disable'));

// Application
$app = App::factory($runMode, $useCache);

// Route
$globals = (PHP_SAPI === 'cli') ? new Globals($argv) : $GLOBALS;
// $router = require dirname(__DIR__) . '/scripts/router/standard_router.php';
$router = new Router; // no router

// Dispatch
list($method, $pagePath, $query) = $router->match($globals);

// Request
$page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();

// Transfer
$app->response->debug()->setResource($page)->prepare()->send();
