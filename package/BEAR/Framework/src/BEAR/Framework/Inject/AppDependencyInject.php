<?php
/**
 * AbstractAppContext
 *
 * @package BEAR.Framework
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface as Di;
use BEAR\Framework\Web\ResponseInterface;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\SignalHandler\Provides;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use BEAR\Framework\Exception\ExceptionHandlerInterface;

/**
 * Application dependency inject
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait AppDependencyInject
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
     * @var BEAR\Resource\Resource
     */
    public $resource;

    /**
     * Response
     *
     * @var ResponseInterface
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
     * @param Di $di
     *
     * @Inject
     */
    public function setDi(Di $di)
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
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * Set response
     *
     * @param ResponseInterface $response
     *
     * @Inject
     */
    public function setResponse(ResponseInterface $response)
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
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
        // resource client
        $resource->attachParamProvider('Provides', new Provides);
        if ($this->cache instanceof Cache) {
            $resource->setCacheAdapter($this->cache);
        }
    }
}
