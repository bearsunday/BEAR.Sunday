<?php
namespace demoWorld;

echo '<h3>PHP Boot</h3>' . number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4) . '<br>';

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
$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);
// include $appPath . '/script/utility/clear_cache.php';
// $mark = microtime(true);
// include $appPath . '/script/exception_handler/standard_handler.php';
// echo '<h3>Init</h3>' . (microtime(true) - $mark) . '<br>';

// Load
$mark = microtime(true);
require $appPath . '/src.php';
echo '<h3>Load</h3>' . number_format((microtime(true) - $mark), 4) . '<br>';

// Route
$mark = microtime(true);
list($method, $pageUri, $query) = require $appPath . '/script/router/standard_router.php';
echo '<h3>Route</h3>' . number_format((microtime(true) - $mark), 4) . '<br>';

// Dispatch
$mark = microtime(true);
list($resource, $page) = (new Dispatcher($appName, $appPath))->getInstance($pageUri);
echo '<h3>Dispatch</h3>' . number_format((microtime(true) - $mark), 4) . '<br>';

// Request
$mark = microtime(true);
$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();
echo '<h3>Page Request</h3>' . number_format((microtime(true) - $mark), 4) . '<br>';

// Output
// header
$mark = microtime(true);
foreach ($response->headers as $header) {
    header($header);
}
// body
echo $response->body;
echo '<h3>Output</h3>' . number_format((microtime(true) - $mark), 4) . '<br>';
echo '<h4>' . 1  / ((microtime(true) -$_SERVER['REQUEST_TIME_FLOAT']))  . ' #/sec</h4>';
exit(0);