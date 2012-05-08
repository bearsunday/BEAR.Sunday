<?php
/**
 * AbstractAppContext
 *
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface as Di;
use Ray\Di\AbstractModule;
use BEAR\Framework\Web\Response;
use BEAR\Resource\Client;
use BEAR\Resource\SignalHandler\Provides;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;

/**
 * Application context
 *
 * @package    BEAR.Framework
 * @subpackage Web
 */
abstract class AbstractAppContext
{
    /**
     * Dependency injector
     *
     * @var Ray\Di\Injector
     */
    public $di;

    /**
     * Resource client
     *
     * @var BEAR\Resource\Client
     */
    public $resource;

    /**
     * Response
     *
     * @var unknown_type
     */
    public $response;

    /**
     * Cache
     *
     * @var unknown_type
     */
    private $cache;

    /**
     * Set cache adapter
     *
     * @param Cache $cache
     *
     * @Inject(optional = true)
     * @Named("resource_cache")
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Property setter
     *
     * @param Di     $di
     * @param Client $resource
     *
     * @Inject
     */
    public function setApplicationProperty(Di $di, Client $resource, Response $response)
    {
        $this->di = $di;
        $this->resource = $resource;
        $this->response = $response;
        // resource client
        $resource->attachParamProvider('Provides', new Provides);
        if ($this->cache instanceof Cache) {
            $resource->setCacheAdapter($this->cache);
        }
    }
}