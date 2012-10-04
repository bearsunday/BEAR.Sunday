<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace Sandbox\Module;

/**
 * Application module for API
 *
 * @package    Sandbox
 * @subpackage Module
 */
class ApiModule extends ProdModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // $this->bind('BEAR\Resource\Renderable')->to('BEAR\Sunday\Resource\View\JsonRenderer');
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Sunday\Resource\View\HalRenderer');
        $this->install(new ProdModule);
    }
}
