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
 * @output array($di, $resource, $page)
 */
namespace BEAR\Framework;

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    BEAR\Framework\FrameWorkModule,
    BEAR\Framework\Router,
    BEAR\Framework\Exception\NotFound;

$start = microtime(true);
$opt = getopt('', array('url:', 'method::'));
list($method, $pageKey) = (new DevRouter)->get($opt);

$cacheFile = $appPath . "/tmp/resource/%%RES%%{$pageKey}";
if (file_exists($cacheFile) === true) {
    list($di, $resource, $page) = unserialize(file_get_contents($cacheFile));
    $dir = (dirname(dirname(dirname($cacheFile))));
    $page->headers['DEV_cache'] = 'X-Cache-Since: ' . date ("r", filemtime($cacheFile)) . ' (' . filesize($cacheFile) . ')';
    $start = microtime(true);
    return array($di, $resource, $page, $method);
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
        throw new NotFound($pageKey);
    } catch (\Exception $e) {
        throw $e;
    }
    file_put_contents($cacheFile, serialize(array($di, $resource, $page)));
    return array($di, $resource, $page, $method);
}