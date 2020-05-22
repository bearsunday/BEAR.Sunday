<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use BEAR\Sunday\Extension\ExtensionInterface;

interface RouterInterface extends ExtensionInterface
{
    /**
     * @param array{_GET: array<string, string>, _POST: array<string, string>}               $globals $GLOBALS
     * @param array{REQUEST_URI: string, REQUEST_METHOD: string, HTTP_CONTENT_TYPE?: string} $server  $_SERVER
     *
     * @return RouterMatch
     */
    public function match(array $globals, array $server);

    /**
     * @param string                $name the route name to look up
     * @param array<string, string> $data the data to interpolate into the URI; data keys map to param tokens in the path
     *
     * @return false|string returns a URI when it finds a name, or boolean false if there is no route name
     */
    public function generate($name, $data);
}
