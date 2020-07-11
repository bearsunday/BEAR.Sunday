<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use function http_build_query;

class RouterMatch
{
    /**
     * Request method
     *
     * @var string
     */
    public $method;

    /**
     * Request path
     *
     * @var string
     */
    public $path;

    /**
     * Request query
     *
     * @var array<string, mixed>
     */
    public $query = [];

    public function __toString(): string
    {
        $querySymbol = $this->query ? '?' : '';

        return "{$this->method} {$this->path}{$querySymbol}" . http_build_query($this->query);
    }
}
