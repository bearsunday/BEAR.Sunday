<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Application;

/**
 * Interdace for web console log
 *
 * @package BEAR.Framework
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
