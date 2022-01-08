<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Application;

use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

/**
 * @deprecated Use AppInterface instead
 *
 * @see https://github.com/bearsunday/BEAR.Skeleton/blob/1.x/src/Module/App.php
 */
class AbstractApp implements AppInterface
{
    /** @var HttpCacheInterface */
    public $httpCache;

    /** @var RouterInterface */
    public $router;

    /** @var TransferInterface */
    public $responder;

    /** @var ResourceInterface */
    public $resource;

    /** @var ErrorInterface */
    public $error;

    /**
     * @param HttpCacheInterface $httpCache HTTP Cache 304 responder
     * @param RouterInterface    $router    Resource router
     * @param TransferInterface  $responder Resource responder
     * @param ResourceInterface  $resource  BEAR.Resource client
     * @param ErrorInterface     $error     Error handler
     */
    public function __construct(
        HttpCacheInterface $httpCache,
        RouterInterface $router,
        TransferInterface $responder,
        ResourceInterface $resource,
        ErrorInterface $error
    ) {
        $this->httpCache = $httpCache;
        $this->router = $router;
        $this->responder = $responder;
        $this->resource = $resource;
        $this->error = $error;
    }
}
