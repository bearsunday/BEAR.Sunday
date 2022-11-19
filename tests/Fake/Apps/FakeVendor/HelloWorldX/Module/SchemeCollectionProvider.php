<?php

namespace FakeVendor\HelloWorldX\Module;

use BEAR\Resource\AppAdapter;
use BEAR\Resource\SchemeCollection;
use FakeVendor\HelloWorld\Module\AppModule as HelloAppModule;
use Ray\Di\Di\Named;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;

class SchemeCollectionProvider implements ProviderInterface
{
    /**
     * @param string $appName
     */
    public function __construct(
        protected InjectorInterface $injector,
        #[Named('app_name')] protected $appName
    ){
    }

    /**
     * Return instance
     *
     * @return SchemeCollection
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection();
        $this->addScheme($schemeCollection, 'self', $this->appName, $this->injector);
        $this->addScheme($schemeCollection, 'hello', 'FakeVendor\HelloWorld', new Injector(new HelloAppModule()));

        return $schemeCollection;
    }

    /**
     * @param string            $host
     * @param string            $appName
     */
    private function addScheme(SchemeCollection $schemeCollection, $host, $appName, InjectorInterface $injector): void
    {
        $schemeCollection->scheme('page')->host($host)->toAdapter(new AppAdapter($injector, $appName));
        $schemeCollection->scheme('app')->host($host)->toAdapter(new AppAdapter($injector, $appName));
    }
}
