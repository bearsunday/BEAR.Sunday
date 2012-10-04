<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

/**
 * Application module for API
 *
 * @package    sandbox
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
        // $this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\JsonRenderer');
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\HalRenderer');
        $this->install(new ProdModule);
    }
}
