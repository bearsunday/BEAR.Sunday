<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Server;

/**
 * Request server values, keyed as PHP-FPM fills $_SERVER
 *
 * Request headers are HTTP_*; Content-Type and Content-Length are CONTENT_TYPE and CONTENT_LENGTH.
 */
interface ServerContextInterface
{
    /** Null when the key is absent or the value is not a string, such as REQUEST_TIME */
    public function get(string $key): string|null;
}
