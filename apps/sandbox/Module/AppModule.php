<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector as Di,
    Ray\Di\Definition;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind()->annotatedWith('Twig')->toProvider('\BEAR\Framework\Module\Provider\TwigProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\sandbox\Module\SchemeCollectionProvider')->in(Scope::SINGLETON);
    }
}