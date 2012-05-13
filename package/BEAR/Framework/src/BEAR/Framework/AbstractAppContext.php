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
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Resource\Client;
use BEAR\Resource\SignalHandler\Provides;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use BEAR\Framework\Exception\ExceptionHandle;

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
     * 
     * @var EexceptionHandle
     */
    public $exceptionHandler;
    
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
     * Set dependency injector
     * 
     * @params Di $di
     * 
     * @Inject
     */
    public function setDi(Di $d)
    {
        $this->di = $di;
    }
    
    /**
     * Set exception handler
     * 
     * @param EexceptionHandle $exceptionHandle
     * 
     * @Inject
     */
    public function setExceptionHandler(ExceptionHandle $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }
    
    /**
     * Set response
     * 
     * @Inject
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
    
    /**
     * Set resource
     *
     * @param Client $resource
     *
     * @Inject
     */
    public function setResource(Client $resource)
    {
        $this->resource = $resource;
        // resource client
        $resource->attachParamProvider('Provides', new Provides);
        if ($this->cache instanceof Cache) {
            $resource->setCacheAdapter($this->cache);
        }
    }
}