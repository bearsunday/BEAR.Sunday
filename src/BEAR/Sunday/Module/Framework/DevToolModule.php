<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace BEAR\Sunday\Module\Framework;

use Ray\Di\AbstractModule;
use BEAR\Sunday\Module as SundayModule;

/**
 * Package module
 *
 * @package    Sandbox
 * @subpackage Module
 */
class DevToolModule extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\DevInvoker');
        $this->install(new SundayModule\TemplateEngine\DevRendererModule);
        $this->install(new SundayModule\Framework\FrameworkModule($this));
        $this->installDevLogger();
    }

    /**
     * Provide debug information
     */
    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function installDevTool()
    {
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\DevInvoker');
        $this->install(new Module\TemplateEngine\DevRendererModule);
    }

    /**
     * Provide debug information
     *
     * depends FrameworkModule
     */
    private function installDevLogger()
    {
        $logger = $this->requestInjection('BEAR\Sunday\Interceptor\Logger');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\Object'),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Log'),
            [$logger]
        );
    }

}
