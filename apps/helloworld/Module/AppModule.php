<?php
/**
 * Module
 *
 * @package    helloworld
 * @subpackage Module
 */
namespace helloworld\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Interceptor\ViewAdapter\SmartyBackend;
use BEAR\Framework\Interceptor\ViewAdapter;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Application module
 *
 * @package    helloworld
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\helloworld\Module\SchemeCollectionProvider');
        $this->install(new Module\TemplateEngine\SmartyModule);
        $this->install(new Module\Extension\ViewModule([new ViewAdapter(new SmartyBackEnd)]));
    }
}