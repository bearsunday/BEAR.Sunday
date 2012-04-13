<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\ViewAdapter;

interface Renderable
{
    public function assign(array $value);
    public function fetch($template);
}