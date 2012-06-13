<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine;

use BEAR\Framework\Interceptor\ViewAdapter;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Smarty module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SmartyModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Smarty')->toProvider('BEAR\Framework\Module\Provider\SmartyProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Framework\Resource\View\TemplateEngineAdapter')->to('BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter')->in(Scope::SINGLETON);
    }
}