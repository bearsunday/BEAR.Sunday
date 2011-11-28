<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

/**
 * Router
 *
 */
class DevRouter
{
    const METHOD_OVERRIDE = 'X-HTTP-Method-Override';

    private $opt;

    public function __construct(array $global)
    {
        $this->global = $global;
    }

    /**
     * Get method
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
        return $method;
    }

    /**
     * Get page key
     *
     * @return array [$method, $pagekey]
     * @throws \InvalidArgumentException
     */
    private function getKey()
    {
        if (!isset($this->global['_SERVER']['REQUEST_URI'])) {
            return '404';
        }
        $pageKey = str_replace('/', '\\', substr($this->global['_SERVER']['REQUEST_URI'], 1));
        return $pageKey;
    }

    public function get()
    {
        $result = array($this->getMethod(), $this->getKey());
        return $result;
    }
}
