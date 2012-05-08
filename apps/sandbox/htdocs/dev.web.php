<?php

namespace sandbox;

use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Framework\Framework;

set_include_path('.');

require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
require_once dirname(__DIR__) . '/App.php';

// require_once dirname(__DIR__) . '/App.php';

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
 * @package BEAR.Framework
 *
 * @global string               $method   Resource method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
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

// Application
$app = App::factory(App::RUN_MODE_STAB);

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
