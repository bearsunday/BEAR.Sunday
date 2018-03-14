<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Extension\Router;

use BEAR\Sunday\Extension\ExtensionInterface;

interface RouterInterface extends ExtensionInterface
{
    /**
     * @param array $globals $GLOBALS
     * @param array $server  $_SERVER
     *
     * @return RouterMatch
     */
    public function match(array $globals, array $server);

    /**
     * @param string $name the route name to look up
     * @param array  $data the data to interpolate into the URI; data keys map to param tokens in the path
     *
     * @return mixed returns a URI when it finds a name, or boolean false if there is no route name
     */
    public function generate($name, $data);
}
