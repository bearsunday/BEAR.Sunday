<?php
use BEAR\Framework\StandardRouter;
use BEAR\Framework\Dispatcher;
use BEAR\Framework\Globals;
use BEAR\Framework\Output\HttpFoundation as Output;
use BEAR\Resource\Object as ResourceObject;

require dirname(dirname(dirname(__DIR__))) . '/vendor/smarty/smarty/libs/Smarty.class.php';

/**
 * CLI / Built-in web server dev script
 *
 * examaple:
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

// Application
$app = require dirname(__DIR__) . '/scripts/instance.php';

// Dispatch
$globals = (PHP_SAPI === 'cli') ? new Globals($argv) : $GLOBALS;
$uri = (PHP_SAPI === 'cli') ? $argv[2] : $globals['_SERVER']['REQUEST_URI'];
$method = (new StandardRouter)->getMethod($globals);
list($resource, $page) = (new Dispatcher($app))->getInstance($uri);

// Request
$response = $app->resource->$method->object($page)->withQuery($globals['_GET'])->eager->request();

if (!($response instanceof ResourceObject)) {
    $page->body = $response;
    $response = $page;
}

// Output
(new Output)->debug()->setResource($response)->request()->be(OUTPUT::FORMAT_VARDUMP)->output();