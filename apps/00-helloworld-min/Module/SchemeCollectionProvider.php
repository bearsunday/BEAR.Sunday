<?php

namespace helloWorld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

use BEAR\Resource\Adapter\App,
    BEAR\Resource\Adapter\Page,
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
     * Return resource adapter set.
     *
     * @return array
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        $schemeCollection->scheme('app')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'ResourceObject'));
        $schemeCollection->scheme('page')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'Page'));
        return $schemeCollection;
    }
}