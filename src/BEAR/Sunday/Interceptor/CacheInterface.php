<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

/**
 * Interface for cache intercepor
 *
 * @package    BEAR.Framework
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
