<?php
/**
 * CLI / Built-in web server script for API.
 *
 * @package BEAR.Framework
 *
 * @global string               $method   Resource rquest method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
 */
use BEAR\Framework\StandardRouter;

use BEAR\Framework\Dispatcher,
    BEAR\Framework\Globals;
use BEAR\Resource\Object as ResourceObject;
use demoworld\App;

// Init
include dirname(dirname(__DIR__)) . '/scripts/exception_handler/api_handler.php';

// Load
require dirname(dirname(__DIR__)) . '/scripts/auto_loader.php';

// Dispatch
if (PHP_SAPI === 'cli') {
    $globals = new Globals($argv);
    $uri = $argv[2];
} else {
    $globals = $GLOBALS;
    $uri = $globals['_SERVER']['REQUEST_URI'];
}
$query = $globals['_GET'];
$method = (new StandardRouter)->getMethod($globals);
list($resource, $page) = (new Dispatcher(new App))->getInstance($uri);

// Request
$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();

// Output
include dirname(dirname(__DIR__)) . '/scripts/output/api.output.php';