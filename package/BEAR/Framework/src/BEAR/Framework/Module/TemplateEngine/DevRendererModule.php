<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

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