<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

final class Header implements HeaderInterface
{
    public function __invoke(ResourceObject $ro, array $server) : void
    {
        foreach ($ro->headers as $label => $value) {
            header("{$label}: {$value}", false);
        }
    }
}
