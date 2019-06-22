<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

interface HeaderInterface
{
    public function __invoke(ResourceObject $ro, array $server) : array;
}
