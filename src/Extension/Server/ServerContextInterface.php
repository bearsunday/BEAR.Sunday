<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Server;

/**
 * Request server values ($_SERVER keys such as 'HTTP_USER_AGENT')
 *
 * A long-running worker (Swoole, RoadRunner) binds a request-scoped implementation.
 */
interface ServerContextInterface
{
    /** Returns null when the key is missing or its value is not a string */
    public function get(string $key): string|null;

    /** True exactly when get() returns a string */
    public function has(string $key): bool;
}
