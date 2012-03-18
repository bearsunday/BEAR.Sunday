<?php
namespace demoworld\Module\Provider;

use Ray\Di\InjectorInterface as Di,
    Ray\Di\ProviderInterface as Provide;

use BEAR\Resource\Adapter\App as AppAdapter,
    BEAR\Resource\Adapter\Http,
    BEAR\Resource\SchemeCollection;
use BEAR\Framework\AbstractAppContext as AppContext;

/**
 * Application resource module
 *
 * @package    helloworld
 * @subpackage Module
 */
class SchemeCollectionProvider implements Provide
{
    /**
     * Constructor
     *
     * @param Inject     $injector
     * @param AppContext $app
     *
     * @Inject
     */
    public function __construct(Di $injector, AppContext $app)
    {
        $this->injector = $injector;
        $this->namespace = $app->name;
    }

    /**
     * Set helloworld application dependency injector
     *
     * @param InjectorInterface $injector
     *
     * @Inject
     * @Named("HelloDi")
     */
    public function setHelloInjector(Di $injector)
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
        $schemeCollection->scheme('app')->host('self')->toAdapter(new AppAdapter($this->injector, $this->namespace, 'Resource\App'));
        $schemeCollection->scheme('page')->host('self')->toAdapter(new AppAdapter($this->injector, $this->namespace, 'Resource\Page'));
        $schemeCollection->scheme('page')->host('helloworld')->toAdapter(new AppAdapter($this->helloInjector, 'helloworld', 'Resource\Page'));
        $schemeCollection->scheme('http')->host('*')->toAdapter(new Http);
        return $schemeCollection;
    }
}