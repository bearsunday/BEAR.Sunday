<?php
namespace demoworld;

use BEAR\Framework\Dispatcher;

/**
 * Web server script for benchmark analysys.
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

// PHP boot
echo '<h3>PHP Boot</h3>' . number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4) . "'<br>\n";

// Init
include dirname(__DIR__) . '/scripts/exception_handler/standard_handler.php';
// include dirname(__DIR__) . '/scripts/utility/clear_cache.php';

// Load
$mark = microtime(true);
require dirname(__DIR__) . '/scripts/auto_loader.php';
$resource = require dirname(__DIR__). '/scripts/resource.php';
echo '<h3>Load</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Route
$mark = microtime(true);
$route = require dirname(__DIR__) . '/scripts/router/standard_router.php';
list($method, $pagePath, $query) = $route->match($GLOBALS);
echo '<h3>Route</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Request
$mark = microtime(true);
$resource->$method->uri('page://self/' . $pagePath)->withQuery($query);
$response = $resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->linkSelf('view')->eager->request();
echo '<h3>Request</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Output
// header
foreach ($response->headers as $header) {
    header($header);
}
// body
echo $response->body;
echo '<h4>' . 1  / ((microtime(true) -$_SERVER['REQUEST_TIME_FLOAT']))  . ' #/sec (' . (number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4)) .')</h4>';
exit(0);