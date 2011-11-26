<?php

namespace helloWorld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

/**
 * Application resource module
 */
class ResourceAdaptersProvider implements ProviderInterface
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
        $schemeNamespace = ['self' => 'helloworld'];
        $resourceAdapters = array(
            'app'  => new \BEAR\Resource\Adapter\App($this->injector, $schemeNamespace),
            'page' => new \BEAR\Resource\Adapter\Page($this->injector, $schemeNamespace)
        );
        return $resourceAdapters;
    }
}