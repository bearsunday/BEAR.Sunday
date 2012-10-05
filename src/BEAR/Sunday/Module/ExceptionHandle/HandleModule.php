<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\ExceptionHandle;

use Ray\Di\AbstractModule;

/**
 * Exception handle module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class HandleModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Exception\ExceptionHandlerInterface')->to('BEAR\Sunday\Exception\ExceptionHandler');
    }
}
