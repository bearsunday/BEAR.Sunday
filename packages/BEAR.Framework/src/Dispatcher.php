<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

use BEAR\Resource\Resource;
use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector;
use BEAR\Framework\Module\StandardModule as FrameWorkModule,
    BEAR\Framework\Router,
    BEAR\Framework\DevRouter,
    BEAR\Framework\Exception\NotFound;

/**
 * Dispatcher
 *
 */
class Dispatcher
{
    /**
     * App Name
     *
     * @var string
     */
    private $appName;

    /**
     * App Path
     *
     * @var string
     */
    private $appPath;

    /**
     * Constructor
     *
     * @param string $appName
     * @param string $appPath
     */
    public function __construct($appName, $appPath)
    {
        $this->appName = $appName;
        $this->appPath = $appPath;
    }

    /**
     * Get instance
     *
     * @param unknown_type $pageResource
     * @throws Exception
     */
    public function getInstance($pageResource)
    {
        $objectCache = $this->appPath . '/tmp/%%RES%%' . str_replace('/', '-', $pageResource);
        if (file_exists($objectCache) === true) {
            $f = file_get_contents($objectCache);
            list($di, $resource, $page) = unserialize($f);
            $dir = (dirname(dirname(dirname($objectCache))));
            $page->headers[] = 'X-Cache-Since: ' . date ("r", filemtime($objectCache)) . ' (' . filesize($objectCache) . ')';
        } else {
            // application fixed instance ($di, $resource)
            $appModule =  '\\' . $this->appName. '\\Module\\AppModule';
            $di = new Injector(new Container(new Forge(new Config(new Annotation))));
            $module = new $appModule(new FrameWorkModule($di));
            $di->setModule($module);
            $resource = $di->getInstance('BEAR\Resource\Client');

            // request URL based page resource instance ($page)
            try {
                $page = $resource->newInstance("page://self/{$pageResource}");
            } catch (\ReflectionException $e) {
                throw $e;
                $page = $resource->newInstance("page://self/code404");
                $page->body = (string)$e;
            } catch (\Exception $e) {
                throw $e;
            }
            file_put_contents($objectCache, serialize([$di, $resource, $page]));
        }
        return [$resource, $page];
    }
}
