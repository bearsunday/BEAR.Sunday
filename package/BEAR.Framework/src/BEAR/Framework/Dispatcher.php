<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

use BEAR\Resource\Resource;
use Ray\Di\Definition,
    Ray\Di\Annotation,
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
        $this->systemPath = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    }

    /**
     * Get instance
     *
     * @param string $pageResource Page resource name
     *
     * @return array [BEAR\Resource\Resource $resource, BEAR\Resource\Object $page]
     *
     * @throws Exception
     */
    public function getInstance($pageResource)
    {
        $cacheFile = $this->appPath . '/tmp/%%res_' . str_replace('/', '-', $pageResource) . '.php';
        $f = apc_fetch($cacheFile);
//         if (file_exists($cacheFile) === true) {
        if ($f) {
//             $f = apc_fetch($cacheFile, $serializedObject);
//             $f = file_get_contents($cacheFile);
            list($resource, $page) = unserialize($f);
            $dir = (dirname(dirname(dirname($cacheFile))));
            $page->headers[] = 'X-Cache-Since: ' . date ("r", filemtime($cacheFile)) . ' (' . filesize($cacheFile) . ')';
        } else {
            // application fixed instance ($di, $resource)
            $appModule =  '\\' . $this->appName. '\\Module\\AppModule';
            $di = new Injector(new Container(new Forge(new Config(new Annotation(new Definition)))));
            $module = new $appModule(new FrameWorkModule($di, $this->appName));
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
            $serializedObject = serialize([$resource, $page]);
            apc_store($cacheFile, $serializedObject);
            // for test
            $sdi = serialize($di);
            unserialize($sdi);
        }
        $providesHandler = require $this->systemPath . '/vendor/BEAR.Resource/scripts/provides_handler.php';
        $resource->attachArgProvider('Provides', $providesHandler);
        return [$resource, $page];
    }
}
