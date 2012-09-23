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
 * Stab module
 *
 * @package    sandbox
 * @subpackage Module
 */
class StabModule extends AbstractModule
{
    /**
     * Configure application
     *
     * @return void
     */
    protected function configure()
    {
        $this->install(new DevModule);
        $stab = include __DIR__ . '/common/stab/resource.php';
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
