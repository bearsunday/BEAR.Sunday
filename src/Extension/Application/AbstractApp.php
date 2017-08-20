<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Extension\Application;

use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class AbstractApp implements AppInterface
{
    /**
     * @var RouterInterface
     */
    public $router;

    /**
     * @var TransferInterface
     */
    public $responder;

    /**
     * @var ResourceInterface
     */
    public $resource;

    /**
     * @var ErrorInterface
     */
    public $error;

    /**
     * @param RouterInterface   $router    Resource router
     * @param TransferInterface $responder Resource responder
     * @param ResourceInterface $resource  BEAR.Resource client
     * @param ErrorInterface    $error     Error handler
     */
    public function __construct(
        RouterInterface $router,
        TransferInterface $responder,
        ResourceInterface $resource,
        ErrorInterface $error
    ) {
        $this->router = $router;
        $this->responder = $responder;
        $this->resource = $resource;
        $this->error = $error;
    }
}
