<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Application;

/**
 * Application logger interface
 *
 * @package    BEAR.Framework
 *
 * @ImplementedBy("BEAR\Framework\Application\Logger")
 */
interface Fireable
{
    /**
     * Fire web console log (FirePHP)
     *
     * @return void
     */
    public function fire();
}
