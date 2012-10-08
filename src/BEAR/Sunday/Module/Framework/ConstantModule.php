<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Framework;

use Ray\Di\AbstractModule;

/**
 * Output console module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class ConstantModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('')->annotatedWith('is_prod')->toInstance(false);
        $sundayDir = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
        $this->bind('')->annotatedWith('sunday_dir')->toInstance($sundayDir);
    }
}
