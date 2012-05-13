<?php
/**
 * CLI  Built-in web server dev script
 *
 * Examaple:
 *
 * CLI:
 * $ php dev.php get /hello
 *
 * Built-in web server:
 *
 * $ php -S localhost:8080 dev.php
 *
 * type URL:
 *   http://localhost:8080/hello
 *   http://localhost:8080/helloresource
 *
 * @package BEAR.Framework
 *
 */
namespace sandbox;

use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Resource\Object as ResourceObject;
use BEAR\Framework\Web\HttpFoundation as Response;

require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
require_once dirname(__DIR__) . '/App.php';

if (php_sapi_name() == 'cli-server') {
    // route static assets and return false
    if (preg_match('/\.(?:png|jpg|jpeg|gif|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

// Application
$runMode = App::RUN_MODE_STAB;
$useCache = false;
$app = App::factory($runMode, $useCache);

// Dispatch
$globals = (PHP_SAPI === 'cli') ? new Globals($argv) : $GLOBALS;
$uri = (PHP_SAPI === 'cli') ? $argv[2] : $globals['_SERVER']['REQUEST_URI'];
list($method, $query) = (new Router)->getMethodQuery($globals);
list($resource, $page) = (new Dispatcher($app))->getInstance($uri);
// Request
$response = $app->resource->$method->object($page)->withQuery($globals['_GET'])->eager->request();
if (!($response instanceof ResourceObject)) {
    $page->body = $response;
    $response = $page;
}

// Output
if (isset($argv[3])) {
    $mode = $argv[3];
    if (! in_array($mode, [Response::MODE_VIEW, Response::MODE_REQUEST, Response::MODE_VALUE])) {
        throw new \InvalidArgumentException($mode);
    }
} else {
    $mode = Response::MODE_REQUEST;
}
$app->response->debug()->setResource($response)->request()->send($mode);
