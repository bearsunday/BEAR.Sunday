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

    /**
     * Get page key
     *
     * @return array [$method, $pagekey]
     * @throws \InvalidArgumentException
     */
    private function getKey()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            goto found;
        }
        if (isset($this->opt['url'])) {
            $url = $this->opt['url'];
            goto found;
        }
        throw new \InvalidArgumentException('URL needed. (ex --url /hello --method get)');
        found:
        $pageKey = substr($url, 1);
        return $pageKey;
    }

    /**
     * Get method
     *
     * @return string
     */
    private function getMethod()
    {
        if (isset($_GET[self::METHOD_OVERRIDE])) {
            return $_GET[self::METHOD_OVERRIDE];
        }
        if (isset($_POST[self::METHOD_OVERRIDE])) {
            return $_POST[self::METHOD_OVERRIDE];
        }
        $method = isset($this->opt['method']) ? $this->opt['method'] : 'get';
        return $method;
    }

    /**
     * Get method and page key
     *
     * @return array
     */
    public function get($opt)
    {
        $this->opt = $opt;
        return [$this->getMethod(), $this->getKey()];
    }
}
