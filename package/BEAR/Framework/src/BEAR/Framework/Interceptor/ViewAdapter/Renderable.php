<?php
/**
 * BEAR.Framework;
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\ViewAdapter;

/**
 * Renderable interface
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
interface Renderable
{
    public function assign(array $value);
    public function fetch($template);
}