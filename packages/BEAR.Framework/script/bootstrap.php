<?php

/**
 * Bootstrap
 *
 * bootstrap provides 3 instances by web context (URL)
 * $di (DiC), $resource (Resource client), $page (Page resource)
 *
 * @package BEAR.Framework
 *
 * @global $appName
 * @global $appPath
 * @global $di
 * @global $resource
 * @global $page
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
<<<<<<< HEAD
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
list($method, $pageKey) = (new DevRouter($globals))->get();
$objectCache = $appPath . '/tmp/%%RES%%' . str_replace('/', '-', $pageKey);

$parsedUrl = parse_url($argv[2]);
if (isset($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $query);
} else {
    $query = array();
}
// get page
if (file_exists($objectCache) === true) {
    $f = file_get_contents($objectCache);
    list($di, $resource, $page) = unserialize($f);
=======
$globals = (PHP_SAPI !== 'cli') ? $GLOBALS : array(
	'_GET' => array(DevRouter::METHOD_OVERRIDE => $argv[1]),
	'_SERVER' => array('REQUEST_URI' => $argv[2])
);
list($method, $pageKey) = (new DevRouter($globals))->get();
$objectCache = $appPath . "/tmp/%%RES%%{$pageKey}";

// get page
if (file_exists($objectCache) === true) {
    list($di, $resource, $page) = unserialize(file_get_contents($objectCache));
>>>>>>> 6cf4176912fd63c895fa2b719add6787ebb3dcc0
    $dir = (dirname(dirname(dirname($objectCache))));
    $page->headers[] = 'X-Cache-Since: ' . date ("r", filemtime($objectCache)) . ' (' . filesize($objectCache) . ')';
} else {
    // application fixed instance ($di, $resource)
    $appModule =  '\\' . $appName. '\\Module\\AppModule';
    $di = new Injector(new Container(new Forge(new Config(new Annotation))));
    $module = new $appModule(new FrameWorkModule($di));
    $di->setModule($module);
    $resource = $di->getInstance('BEAR\Resource\Client');

    // request URL based page resource instance ($page)
    try {
        $page = $resource->newInstance("page://self/{$pageKey}");
    } catch (\ReflectionException $e) {
<<<<<<< HEAD
        throw $e;
        $page->body = (string)$e;
=======
        $page = $resource->newInstance("page://self/code404");
>>>>>>> 6cf4176912fd63c895fa2b719add6787ebb3dcc0
    } catch (\Exception $e) {
        throw $e;
    }
    file_put_contents($objectCache, serialize(array($di, $resource, $page)));
<<<<<<< HEAD
}
=======
}
>>>>>>> 6cf4176912fd63c895fa2b719add6787ebb3dcc0
