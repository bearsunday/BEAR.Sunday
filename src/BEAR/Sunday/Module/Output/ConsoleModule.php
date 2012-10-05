<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Output;

use Ray\Di\AbstractModule;

/**
 * Output console module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class ConsoleModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Output\ConsoleInterface')->to('BEAR\Sunday\Output\Console');
    }
}
