<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use BEAR\Sunday\Extension\ExtensionInterface;

interface RouterInterface extends ExtensionInterface
{
    /**
     * @param array{_GET: array<string, string|array>, _POST: array<string, string|array>} $globals $GLOBALS
     * @param array<string, mixed>                                                         $server  $_SERVER
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
