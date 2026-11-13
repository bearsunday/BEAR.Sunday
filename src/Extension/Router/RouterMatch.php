<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use Override;
use Stringable;

use function http_build_query;
use function strpos;
use function substr;

class RouterMatch implements Stringable
{
    /** @param array<string, mixed> $query */
    public function __construct(
        public string $method = '',
        public string $path = '',
        public array $query = [],
    ) {
    }

    #[Override]
    public function __toString(): string
    {
        $path = $this->path;
        $fragment = '';
        $fragmentPos = strpos($path, '#');
        if ($fragmentPos !== false) {
            $fragment = substr($path, $fragmentPos);
            $path = substr($path, 0, $fragmentPos);
        }

        $querySymbol = $this->query ? '?' : '';

        return "{$this->method} {$path}{$querySymbol}" . http_build_query($this->query) . $fragment;
    }
}
