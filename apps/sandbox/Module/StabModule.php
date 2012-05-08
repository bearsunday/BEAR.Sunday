<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use Ray\Di\AbstractModule;
use BEAR\Framework\Interceptor\Stab;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class StabModule extends AbstractModule
{
    /**
     * App class
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
        parent::__construct();
    }

    /**
     * Configure application
     *
     * @return void
     */
    protected function configure()
    {
        $this->install(new DevModule($this->app));
        $stab = include __DIR__ . '/stab/resource.php';
        $this->installResourceStab($stab);
    }

    /**
     * Install resource stab
     *
     * @param array $stab
     *
     * @return void
     */
    protected function installResourceStab(array $stab)
    {
        foreach ($stab as $class => $value) {
            $this->bindInterceptor(
                $this->matcher->subclassesOf($class),
                $this->matcher->any(),
                [new Stab($value)]
            );
        }
    }
}
