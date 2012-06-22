<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine\SmartyModule;

use BEAR\Framework\Interceptor\ViewAdapter;
use BEAR\Framework\AppDieInject;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use ReflectionClass;
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
        $this->bind('Smarty')->toProvider('BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Framework\Resource\View\TemplateEngineAdapter')->to('BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyAdapter')->in(Scope::SINGLETON);
    }
}