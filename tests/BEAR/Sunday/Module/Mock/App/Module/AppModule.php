<?php
namespace BEAR\Sunday\Module\Mock\App\Module;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface as Di;
use Ray\Di\Injector;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    public function __construct(Di $injector)
    {
        $this->injector = $injector;
        parent::__construct();
    }

    /**
     * Binding configuration
     *
     * @return void
     */
    protected function configure()
    {
    }
}
