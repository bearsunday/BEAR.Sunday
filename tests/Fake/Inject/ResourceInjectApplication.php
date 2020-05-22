<?php

namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;

class ResourceInjectApplication
{
    use ResourceInject;

    public function returnDependency(): ResourceInterface
    {
        return $this->resource;
    }
}
