<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
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
}
