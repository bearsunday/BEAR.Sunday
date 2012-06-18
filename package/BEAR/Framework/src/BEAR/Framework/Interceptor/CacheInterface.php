<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

/**
 * Cache intercepor interface
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