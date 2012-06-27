<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine;

use Ray\Di\AbstractModule;

/**
 * Resource renderer module - PROD
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class ProdRendererModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\Renderer');
    }
}
