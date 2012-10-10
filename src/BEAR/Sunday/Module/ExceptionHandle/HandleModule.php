<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\ExceptionHandle;

use Ray\Di\AbstractModule;

/**
 * Exception handle module
 *
 * @package    BEAR.Sunday
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
