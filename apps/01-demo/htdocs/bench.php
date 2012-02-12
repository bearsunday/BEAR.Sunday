<?php
namespace demoWorld;
echo '<h3>PHP Boot</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';

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

$appName = __NAMESPACE__;
$appPath = dirname(__DIR__);

require $appPath . '/src.php';

echo '<h3>Load</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';
// list($method, $pageUri, $query) = require $appPath . '/script/router/standard_router.php';

list($method, $pageUri, $query) = require $appPath . '/script/router/no_router.php';
echo '<h3>Route</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';

list($resource, $page) = (new Dispatcher($appName, $appPath))->getInstance($pageUri);
echo '<h3>Dispatch</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';

$response = $resource->$method->object($page)->withQuery($query)->linkSelf('view')->eager->request();
echo '<h3>Page Request</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';

// header
foreach ($response->headers as $header) {
    header($header);
}
// body
echo $response->body;
echo '<h3>Output</h3>' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br>';
echo '<h4>' . 1  / ((microtime(true) -$_SERVER['REQUEST_TIME_FLOAT']))  . ' #/sec</h4>';


