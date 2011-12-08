<?php

namespace helloWorld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

use BEAR\Resource\Adapter\App,
    BEAR\Resource\Adapter\Page;

/**
 * Application resource module
 */
class ResourceAdapterProvider implements ProviderInterface
{
    /**
     * @param InjectorInterface $injector
     *
     * @Inject
     */
    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }

    /**
     * @return array
     */
    public function get()
    {
        $schemeNamespace = ['self' => 'helloWorld'];
        $resourceAdapters = array(
            'app'  => new App($this->injector, $schemeNamespace),
            'page' => new Page($this->injector, $schemeNamespace)
        );
        return $resourceAdapters;
    }
}