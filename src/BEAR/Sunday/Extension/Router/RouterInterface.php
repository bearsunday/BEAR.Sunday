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
     * Match route
     *
     * @return array [$method, $pageUri, $query]
     */
    public function match();
}
