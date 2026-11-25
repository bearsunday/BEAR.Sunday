<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Server;

use BEAR\Sunday\Extension\Server\ServerContextInterface;
use Override;

use function is_string;

/**
 * Reads $_SERVER; safe only where a worker serves one request at a time (PHP-FPM)
 */
final class GlobalServerContext implements ServerContextInterface
{
    #[Override]
    public function get(string $key): string|null
    {
        $value = $_SERVER[$key] ?? null;

        return is_string($value) ? $value : null;
    }

    #[Override]
    public function has(string $key): bool
    {
        return isset($_SERVER[$key]);
    }
}
