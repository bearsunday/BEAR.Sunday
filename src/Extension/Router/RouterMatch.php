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

    /**
     * @param array<string, mixed> $query
     */
    public function __construct(string $method = '', string $path = '', array $query = [])
    {
        $this->method = $method;
        $this->path = $path;
        $this->query = $query;
    }

    public function __toString(): string
    {
        $querySymbol = $this->query ? '?' : '';

        return "{$this->method} {$this->path}{$querySymbol}" . http_build_query($this->query);
    }
}
