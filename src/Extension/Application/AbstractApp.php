<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
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
     * @param RouterInterface   $router
     * @param TransferInterface $responder
     * @param ResourceInterface $resource
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
