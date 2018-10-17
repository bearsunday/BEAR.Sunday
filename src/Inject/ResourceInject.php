<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;

trait ResourceInject
{
    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * @Ray\Di\Di\Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}
