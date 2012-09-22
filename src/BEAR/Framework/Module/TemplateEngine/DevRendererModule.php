<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\TemplateEngine;

use Ray\Di\AbstractModule;

/**
 * Resource renderer module - DEV
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DevRendererModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\DevRenderer');
    }
}
