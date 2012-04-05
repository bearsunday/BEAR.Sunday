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
        // (string)resouce view
        $this->installResouceViewAdapter();
        // interceptor view
        $this->install(new Module\Extension\ViewModule([new ViewAdapter(new SmartyBackEnd)]));
    }

    /**
     * Install view adapter (string)resource
     */
    private function installResouceViewAdapter()
    {
        $this
        ->bind('BEAR\Framework\View\Renderable')
        ->annotatedWith('link')
        ->to('\BEAR\Framework\View\SmartyAdapter');

        $this
        ->bind('\Smarty')
        ->toProvider('\BEAR\Framework\Module\Provider\SmartyProvider')
        ->in(Scope::SINGLETON);;

        $this
        ->bind()->annotatedWith('template_ext')
        ->toInstance('tpl');
    }
}