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
     * @var string
     */
    protected $appName;

    /**
     * @var InjectorInterface
     */
    protected $injector;

    /**
     * @Named("appName=app_name")
     */
    public function __construct(InjectorInterface $injector, $appName)
    {
        $this->injector = $injector;
        $this->appName = $appName;
    }

    /**
     * Return instance
     *
     * @return SchemeCollection
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        $this->addScheme($schemeCollection, 'self', $this->appName, $this->injector);
        $this->addScheme($schemeCollection, 'hello', 'FakeVendor\HelloWorld', new Injector(new HelloAppModule));

        return $schemeCollection;
    }

    /**
     * @param SchemeCollection  $schemeCollection
     * @param string            $host
     * @param string            $appName
     * @param InjectorInterface $injector
     */
    private function addScheme(SchemeCollection $schemeCollection, $host, $appName, InjectorInterface $injector)
    {
        $schemeCollection->scheme('page')->host($host)->toAdapter(new AppAdapter($injector, $appName));
        $schemeCollection->scheme('app')->host($host)->toAdapter(new AppAdapter($injector, $appName));
    }
}
