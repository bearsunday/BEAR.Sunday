<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework;

use BEAR\Resource\Resource;
use Aura\Router\Map;

/**
 * Standard Router
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
final class StandardRouter
{
    /**
     * $GLOBALS
     *
     * @var array
     */
    private $globals;

    /**
     * map
     *
     * @var Aura\Router\Map;
     */
    private $map;

    const METHOD_OVERRIDE = 'X-HTTP-Method-Override';

    public function __construct(Map $map = null)
    {
        $this->map = $map;
    }

    public function match($globals)
    {
        $this->globals = $globals;
        $uri = $globals['_SERVER']['REQUEST_URI'];
        $query = $globals['_GET'];
        $route = $this->map ? $this->map->match(parse_url($uri, PHP_URL_PATH), $globals['_SERVER']) : false;
        if ($route === false) {
            $method = strtolower($this->getMethod($globals));
            $pageUri = $this->getPageKey();
            $query = $globals['_GET'];
        } else {
            $method = $route->values['action'];
            $pageUri = $route->values['page'];
            $query = [];
            foreach ($route->params as $key => $params) {
                $query[$key] = $route->values[$key];
            }
        }
        return [$method, $pageUri, $query];
    }

    /**
     * Return request method
     *
     * @return string
     */
    public function getMethod($globals)
    {
        if ($globals['_SERVER']['REQUEST_METHOD'] === 'get' && isset($globals['_GET'][self::METHOD_OVERRIDE])) {
            $method = $globals['_GET'][self::METHOD_OVERRIDE];
            goto complete;
        }
        if ($globals['_SERVER']['REQUEST_METHOD'] === 'post' && isset($globals['_POST'][self::METHOD_OVERRIDE])) {
            $method = $globals['_POST'][self::METHOD_OVERRIDE];
            goto complete;
        }
        $method = $globals['_SERVER']['REQUEST_METHOD'];

        complete:
        return strtolower($method);
    }

    /**
     * Return page key
     *
     * @return array [$method, $pagekey]
     * @throws \InvalidArgumentException
     */
    private function getPageKey()
    {
        if (!isset($this->globals['_SERVER']['REQUEST_URI'])) {
            return '404';
        }
        $pageKey = substr($this->globals['_SERVER']['REQUEST_URI'], 1);
        return $pageKey;
    }
}