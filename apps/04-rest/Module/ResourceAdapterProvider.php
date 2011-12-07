<?php

namespace restWorld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

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
        $schemeNamespace = ['self' => 'restWorld'];
        $resourceAdapters = array(
            'app'  => new \BEAR\Resource\Adapter\App($this->injector, $schemeNamespace),
            'page' => new \BEAR\Resource\Adapter\Page($this->injector, $schemeNamespace)
        );
        return $resourceAdapters;
    }
}