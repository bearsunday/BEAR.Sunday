<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

interface ConditionalResponseInterface
{
    /**
     * Is resource state modified upon conditional request
     */
    public function isModified(ResourceObject $ro, array $server) : bool;

    /**
     * Return 304 Not Modified output
     */
    public function getOutput(array $headers) : Output;
}
