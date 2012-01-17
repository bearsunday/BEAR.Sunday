<?php
/**
 * Standard Router
 *
 * @global \Aura\Router\Map $map
 * @global array            $globals
 * @global array            $pageResource
 * @global array            $query
 */
namespace BEAR\Application\Script;

use BEAR\Framework\DevRouter;

$map = require __DIR__ . '/map.php';

// set $globals
if  (PHP_SAPI !== 'cli') {
    $globals = $GLOBALS;
} else {
    if (!isset($argv[1]) || !isset($argv[2])) {
        echo 'usage: <method> <uri>' . PHP_EOL;
        exit(1);
    }
    $globals = array(
        '_GET' => array(DevRouter::METHOD_OVERRIDE => $argv[1]),
        '_SERVER' => array('REQUEST_URI' => $argv[2])
    );
}
$route = $map->match(parse_url($globals['_SERVER']['REQUEST_URI'], PHP_URL_PATH), $_SERVER);
if ($route === false) {
    list($method, $pageResource) = (new DevRouter($globals))->get();
    if (isset($parsedUrl['query'])) {
        parse_str(parse_url($argv[2])['query'], $query);
    } else {
        $query = [];
    }
} else {
    $method = $route->values['action'];
    $pageResource = $route->values['page'];
    $query = [];
    foreach ($route->params as $key => $params) {
        $query[$key] = $route->values[$key];
    }
}
unset($map);
unset($route);
unset($globals);
return [$method, $pageResource, $query];