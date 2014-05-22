<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Router;

use BEAR\Sunday\Extension\ExtensionInterface;

/**
 * Interface for router
 */
interface RouterInterface extends ExtensionInterface
{
    /**
     * Set globals
     *
     * @param mixed $globals array | \ArrayAccess
     *
     * @return self
     */
    public function setGlobals($globals);

    /**
     * Set argv
     *
     * @param mixed $argv array | \ArrayAccess
     *
     * @return mixed
     */
    public function setArgv($argv);

    /**
     * Match route
     *
     * @return array [$method, $pageUri, $query]
     */
    public function match();
}
