<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Log;

use Ray\Di\AbstractModule;

/**
 * Application logger module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ApplicationLoggerModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Application\LoggerInterface')->to('BEAR\Sunday\Application\Logger');
    }
}
