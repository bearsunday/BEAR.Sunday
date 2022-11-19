<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use Stringable;

use function http_build_query;

class RouterMatch implements Stringable
{
    /** @param array<string, mixed> $query */
    public function __construct(
        public string $method = '',
        public string $path = '',
        public array $query = [],
    ) {
    }

    public function __toString(): string
    {
        $querySymbol = $this->query ? '?' : '';

        return "{$this->method} {$this->path}{$querySymbol}" . http_build_query($this->query);
    }
}
