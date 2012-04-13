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
    const SMARTY   = 'BEAR\Framework\Module\Provider\SmartyProvider';
    const RENDERER = 'BEAR\Framework\Module\TemplateEngine\SmartyModule\SmartyRednererProvider';

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Smarty')->toProvider(self::SMARTY)->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\Renderable')->toProvider(self::RENDERER);

//         $this->bind('BEAR\Framework\Resource\View\ViewAdapter')
//         ->to('BEAR\Framework\Interceptor\ViewAdapter\SmartyBackEnd');
    }
}