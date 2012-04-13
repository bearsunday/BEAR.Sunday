<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine;

use BEAR\Framework\Module\Extension\ViewModule;

use Ray\Di\Scope;

use BEAR\Framework\Module;
use BEAR\Framework\Interceptor\ViewAdapter;
use BEAR\Framework\Interceptor\ViewAdapter\SmartyBackEnd;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

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
        $this->bind('Smarty')
        ->toProvider('\BEAR\Framework\Module\Provider\SmartyProvider')->in(Scope::SINGLETON);

        $this->bind('BEAR\Resource\Renderable')
        ->toProvider('BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyRednererProvider');

        $this->bind('BEAR\Framework\Resource\View\ViewAdapter')
        ->to('BEAR\Framework\Interceptor\ViewAdapter\SmartyBackEnd');
    }
}