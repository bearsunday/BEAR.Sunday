<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\TemplateEngine;

use Ray\Di\AbstractModule;

/**
 * Resource renderer module - PROD
 *
 * @package    BEAR.Sunday
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
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Sunday\Resource\View\Renderer');
    }
}
