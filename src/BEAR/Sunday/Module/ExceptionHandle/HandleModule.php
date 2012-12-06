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
        $this->bind('')->annotatedWith('exceptionTpl')->toInstance(__DIR__ . '/template/exception.tpl.php');
        $this->bind('BEAR\Resource\AbstractObject')->annotatedWith('errorPage')->to('BEAR\Sunday\Resource\Page\Error');
        $this->bind('BEAR\Sunday\Exception\ExceptionHandlerInterface')->to('BEAR\Sunday\Exception\ExceptionHandler');
    }
}
