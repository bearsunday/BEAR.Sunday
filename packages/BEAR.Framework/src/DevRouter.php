<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

use BEAR\Resource\Resource;

/**
 * Router
 *
 */
use Ray\Di\InjectorInterface;

class DevRouter
{
    const METHOD_OVERRIDE = 'X-HTTP-Method-Override';

    private $opt;

    public function __construct(array $global)
    {
        $this->global = $global;
    }

    /**
     * Return request method
     *
     * @return string
     */
    private function getMethod()
    {
        if (isset($this->global['_GET'][self::METHOD_OVERRIDE])) {
            return $this->global['_GET'][self::METHOD_OVERRIDE];
        }
        if (isset($this->global['_POST'][self::METHOD_OVERRIDE])) {
            return $this->global['_POST'][self::METHOD_OVERRIDE];
        }
		$method = 'get';
        return $method;
    }

    /**
     * Return page key
     *
     * @return array [$method, $pagekey]
     * @throws \InvalidArgumentException
     */
    private function getPageKey()
    {
        if (!isset($this->global['_SERVER']['REQUEST_URI'])) {
            return '404';
        }
        $pageKey = substr($this->global['_SERVER']['REQUEST_URI'], 1);
        return $pageKey;
    }

    /**
     * Return page method and page key
     *
     * @return multitype:string Ambigous <multitype:, string, mixed>
     */
    public function get()
    {
        $result = [$this->getMethod(), $this->getPageKey()];
        return $result;
    }

    /**
     * Dispacth
     *
     * @param Resource $resource
     *
     * @return array [string, Resource] multitype:string unknown
     */
    public function dispatch(Resource $resource)
    {
        $method = $this->getMethod();
        $uri = $this->global['_SERVER']['REQUEST_URI'];
        $ro = $resource->newInstance($uri);
        return [$method, $ro];
    }
}
