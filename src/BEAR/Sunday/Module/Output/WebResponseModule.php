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
 * Web response module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class WebResponseModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Web\ResponseInterface')->to('BEAR\Sunday\Web\SymfonyResponse');
    }
}
