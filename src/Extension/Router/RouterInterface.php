<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use BEAR\Sunday\Extension\ExtensionInterface;

/**
 * @psalm-type Globals = array{
 *     _GET: array<string, mixed>,
 *     _POST: array<string, mixed>
 * }
 * @psalm-type Server = array{
 *     REQUEST_URI: string,
 *     REQUEST_METHOD: string,
 *     CONTENT_TYPE?: string,
 *     HTTP_CONTENT_TYPE?: string,
 *     HTTP_RAW_POST_DATA?: string
 * }
 */
interface RouterInterface extends ExtensionInterface
{
    /**
     * @param Globals $globals
     * @param Server  $server
     *
     * @return RouterMatch
     */
    public function match(array $globals, array $server);

    /**
     * @param string               $name the route name to look up
     * @param array<string, mixed> $data the data to interpolate into the URI; data keys map to param tokens in the path
     *
     * @return false|string returns a URI when it finds a name, or boolean false if there is no route name
     */
    public function generate($name, $data);
}
