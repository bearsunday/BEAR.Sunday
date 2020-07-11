<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

interface ConditionalResponseInterface
{
    /**
     * Is resource state modified upon conditional request
     *
     * @param array{HTTP_IF_NONE_MATCH?: string} $server
     */
    public function isModified(ResourceObject $ro, array $server): bool;

    /**
     * Return 304 Not Modified output
     *
     * @param array<string, string> $headers
     */
    public function getOutput(array $headers): Output;
}
