<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Router;

/**
 * Interface for router
 *
 * @package    BEAR.Sunday
 * @subpackage Web
 */
interface RouterInterface
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
     * @param $argv array | \ArrayAccess
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
