<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Application;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface;
use BEAR\Framework\AppContext;
use BEAR\Framework\Web\ResponseInterface;
use BEAR\Framework\Exception\ExceptionHandlerInterface;
use BEAR\Framework\Application\Logger as ApplicationLogger;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\Logger as ResourceLoggerInterface;
use BEAR\Resource\SignalHandler\Provides;
use Guzzle\Common\Cache\CacheAdapterInterface;

/**
 * Abstract App
 *
 * @package BEAR.Framework
 */
abstract class AbstractApp implements AppContext
{
    /**
     * Dependency injector
     *
     * @var Ray\Di\Injector
     */
    public $injector;

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
     * Resource logger
     *
     * @var BEAR\Resource\Logger
     */
    public $logger = [];

    /**
     * Constructor
     *
     * @param CacheAdapterInterface     $cache
     * @param InjectorInterface         $di
     * @param ExceptionHandlerInterface $exceptionHandler
     * @param ResponseInterface         $response
     * @param ApplicationLogger         $logger
     *
     * @Inject
     * @Named("cache=resource_cache")
     */
    public function __construct(
        InjectorInterface $injector,
        ResourceInterface $resource,
        ExceptionHandlerInterface $exceptionHandler,
        ResponseInterface $response,
        CacheAdapterInterface $cache = null,
        ApplicationLogger $logger = null
    ){
        $this->injector = $injector;
        $this->resource = $resource;
        $this->response = $response;
        $this->exceptionHandler = $exceptionHandler;
        $this->cache = $cache;
        $this->logger = $logger;
        //
        $resource->attachParamProvider('Provides', new Provides);
        if ($this->cache instanceof CacheAdapterInterface) {
            $resource->setCacheAdapter($this->cache);
        }
    }
}
