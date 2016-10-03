<?php

namespace BEAR\Sunday\Inject;

class ResourceInjectApplication
{
    use ResourceInject;

    public function returnDependency()
    {
        return $this->resource;
    }
}
