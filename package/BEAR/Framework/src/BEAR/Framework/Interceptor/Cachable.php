<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

/**
 * Cache intercepor interface
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
interface Cachable
{
    /**
     * Delete cache data
     *
     * @param string $class
     * @param array  $args
     */
    public function delete($class, array $args);
}