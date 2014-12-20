<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;

trait ResourceInject
{
    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * @param ResourceInterface $resource
     *
     * @Ray\Di\Di\Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}
