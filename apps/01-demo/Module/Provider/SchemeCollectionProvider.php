<?php

namespace demoWorld\Module\Provider;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

use BEAR\Resource\Adapter\App,
    BEAR\Resource\Adapter\Http,
    BEAR\Resource\SchemeCollection;

/**
 * Application resource module
 *
 * @package    helloWorld
 * @subpackage Module
 */
class SchemeCollectionProvider implements ProviderInterface
{
    /**
     * Constructor
     *
     * @param InjectorInterface $injector
     *
     * @Inject
     * @Named("appName=AppName")
     */
    public function __construct(InjectorInterface $injector, $appName)
    {
        $this->injector = $injector;
        $this->namespace = $appName;
    }

    /**
     * Set helloWorld application dependency injector
     *
     * @param InjectorInterface $injector
     *
     * @Inject
     * @Named("HelloDi")
     */
    public function setHelloInjector(InjectorInterface $injector)
    {
        $this->helloInjector = $injector;
    }

    /**
     * Return resource adapter set.
     *
     * @return array
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        $schemeCollection->scheme('app')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'ResourceObject'));
        $schemeCollection->scheme('page')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'Page'));
        $schemeCollection->scheme('page')->host('helloworld')->toAdapter(new App($this->helloInjector, 'helloWorld', 'Page'));
        $schemeCollection->scheme('http')->host('*')->toAdapter(new Http);
        return $schemeCollection;
    }
}