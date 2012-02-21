<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

use Ray\Di\Definition,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\InjectorInterface as Inject;
use BEAR\Framework\Module\StandardModule as FrameWorkModule;

/**
 * Application context
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
abstract class AbstractAppContext
{
    /**
     * Application Version
     *
     * @var string
     */
    const VERSION = '0.0.0';
    /**
     * Application name
     *
     * @var string
     */
    public $name;

    /**
     * Application porject root path
     *
     * @var string
     */
    public $path;

    /**
     * Return factory for resource client and page resource
     *
     * @return callable
     *
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getResourceFactory()
    {
        return function ($appName, $pageUri){
            $appModule =  '\\' . $appName. '\\Module\\AppModule';
            $di = new Injector(new Container(new Forge(new Config(new Annotation(new Definition)))));
            $module = new $appModule(new FrameWorkModule($di, $appName));
            $di->setModule($module);
            $resource = $di->getInstance('BEAR\Resource\Client');
            // request URL based page resource instance ($page)
            try {
                $page = $resource->newInstance($pageUri);
            } catch (\ReflectionException $e) {
                throw $e;
                $page = $resource->newInstance("page://self/code404");
                $page->body = (string)$e;
            } catch (\Exception $e) {
                throw $e;
            }
            return [$resource, $page];
        };
    }

    /**
     * to string
     */
    public function __toString()
    {
        return $this->name . self::VERSION;
    }
}