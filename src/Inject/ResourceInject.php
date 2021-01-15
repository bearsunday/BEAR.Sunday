<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;
use Ray\Di\Di\Inject;

trait ResourceInject
{
    /** @var ResourceInterface */
    protected $resource;

    /**
     * @\Ray\Di\Di\Inject
     * @codeCoverageIgnore
     */
    #[Inject]
    public function setResource(ResourceInterface $resource): void
    {
        $this->resource = $resource;
    }
}
