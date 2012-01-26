<?php

/**
 * Bootstrap
 *
 * bootstrap provides 3 instances by web context (URL)
 * $di (DiC), $resource (Resource client), $page (Page resource)
 *
 * @package BEAR.Framework
 *
 * @input  void
 * @output [$di, $resource, $page]
 */
namespace BEAR\Framework;

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    BEAR\Framework\Module\StandardModule as FrameWorkModule,
    BEAR\Framework\Router,
    BEAR\Framework\Exception\NotFound;

// router
if  (PHP_SAPI !== 'cli') {
    $globals = $GLOBALS;
} else {
    if (!isset($argv[1]) || !isset($argv[2])) {
        echo 'usage: <method> <uri>' . PHP_EOL;
        exit(1);
    }
    $globals = [
        '_GET' => [DevRouter::METHOD_OVERRIDE => $argv[1]],
        '_SERVER' => ['REQUEST_URI' => $argv[2]]
    ];
}

$di = require $appPath . '/script/di.php';
$resource = $di->getInstance('BEAR\Resource\Client');

list($method, $ro) = (new DevRouter($globals))->dispatch($resource);
$objectCache = $appPath . '/tmp/%%RES%%' . get_class($ro);

$parsedUrl = parse_url($argv[2]);
if (isset($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $query);
} else {
    $query = array();
}
// get page
if (file_exists($objectCache) === true) {
    list($di, $resource, $ro) = unserialize(file_get_contents($objectCache));
    $dir = (dirname(dirname(dirname($objectCache))));
    $page->headers[] = 'X-Cache-Since: ' . date ("r", filemtime($objectCache)) . ' (' . filesize($objectCache) . ')';
} else {
    file_put_contents($objectCache, serialize([$di, $resource, $ro]));
    list($di, $resource, $ro) = unserialize(file_get_contents($objectCache));
}
