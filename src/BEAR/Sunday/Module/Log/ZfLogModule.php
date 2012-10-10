<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Log;

use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;

/**
 * ZF2 logger module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ZfLogModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Guzzle\Common\Log\LogAdapterInterface')->to('Guzzle\Common\Log\Zf2LogAdapter');
    }
}
