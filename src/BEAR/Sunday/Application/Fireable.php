<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Application;

/**
 * Interface for web console log
 *
 * @package BEAR.Sunday
 *
 * @ImplementedBy("BEAR\Sunday\Application\Logger")
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
