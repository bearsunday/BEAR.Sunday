<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Application;

use BEAR\Resource\ResourceInterface;
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
     * @param RouterInterface   $router
     * @param TransferInterface $responder
     */
    public function __construct(
        RouterInterface $router,
        TransferInterface $responder,
        ResourceInterface $resource
    ) {
        $this->router = $router;
        $this->responder = $responder;
        $this->resource = $resource;
    }
}
