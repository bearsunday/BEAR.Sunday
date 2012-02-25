<?php

namespace helloworld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

use BEAR\Resource\Adapter\App,
    BEAR\Resource\Adapter\Page,
    BEAR\Resource\SchemeCollection;

/**
 * Application resource module
 *
 * @package    helloworld
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
        $schemeCollection->scheme('page')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'Resource\Page'));
        return $schemeCollection;
    }
}