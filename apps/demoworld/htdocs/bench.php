<?php
namespace demoworld;

echo '<h3>PHP Boot</h3>' . number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4) . "'<br>\n";

use BEAR\Framework\Dispatcher;

/**
 * Web server script for benchmark analysys.
 *
 * @package BEAR.Framework
 *
 * @global string               $method   Resource method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
 */

// Init
// include dirname(__DIR__) . '/scripts/exception_handler/standard_handler.php';
// include dirname(__DIR__) . '/scripts/utility/clear_cache.php';

// Load
$mark = microtime(true);
require dirname(__DIR__) . '/scripts/auto_loader.php';
echo '<h3>Load</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Route
$mark = microtime(true);
$route = require dirname(__DIR__) . '/scripts/router/standard_router.php';
list($method, $pagePath, $query) = $route->match($GLOBALS);
echo '<h3>Route</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Dispatch
$mark = microtime(true);
list($resource, $page) = (new Dispatcher(new App))->getInstance('page://self/' . $pagePath);
echo '<h3>Dispatch</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Request
$mark = microtime(true);
$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();
echo '<h3>Request</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";

// Output
// header
foreach ($response->headers as $header) {
    header($header);
}
// body
echo $response->body;
echo '<h3>Output</h3>' . number_format((microtime(true) - $mark), 4) . "'<br>\n";
echo '<h4>' . 1  / ((microtime(true) -$_SERVER['REQUEST_TIME_FLOAT']))  . ' #/sec</h4>';
exit(0);