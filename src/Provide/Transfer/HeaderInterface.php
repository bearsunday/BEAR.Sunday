<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

interface HeaderInterface
{
    /**
     * @param array<string, string> $server
     *
     * @return array<string, string>
     */
    public function __invoke(ResourceObject $ro, array $server): array;
}
