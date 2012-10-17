<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

/**
 * Interface for cache interceptor
 *
 * @package    BEAR.Sunday
 * @subpackage Interceptor
 */
interface CacheInterface
{
    /**
     * Delete cache data
     *
     * @param string $class
     * @param array  $args
     *
     * @return void
     */
    public function delete($class, array $args);
}
