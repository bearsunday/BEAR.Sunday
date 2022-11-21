<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

final class Output extends ResourceObject
{
    /** @param array<string, string> $headers */
    public function __construct(int $code, array $headers, string $view)
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->view = $view;
        $this->body = [];
    }
}
