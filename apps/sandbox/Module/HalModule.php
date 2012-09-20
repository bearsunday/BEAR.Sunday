<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

/**
 * Application module for API (JSON + HAL)
 *
 * @package    sandbox
 * @subpackage Module
 *
 * @see http://stateless.co/hal_specification.html
 */
class HalModule extends ProdModule
{
    /**
     * Application path
     *
     * @var string
     */
    private $app;

    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        parent::__construct($app);
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Framework\Resource\View\HalRenderer');
        $this->install(new ProdModule($this->app));
    }
}
