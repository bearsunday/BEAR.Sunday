<?php
namespace sandbox\Module;

use Ray\Di\InjectorInterface as Di,
    Ray\Di\ProviderInterface as Provide;

use BEAR\Resource\Adapter\App as AppAdapter,
    BEAR\Resource\Adapter\Page,
    BEAR\Resource\SchemeCollection,
    BEAR\Framework\AbstractAppContext as AppContext;

/**
 * Application resource module
 *
 * @package    sandbox
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
        $this->namespace = $app::NAME;
    }

    /**
     * Return resource adapter set.
     *
     * @return array
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        $schemeCollection->scheme('page')->host('self')->toAdapter(new AppAdapter($this->injector, $this->namespace, 'Resource\Page'));
        $schemeCollection->scheme('app')->host('self')->toAdapter(new AppAdapter($this->injector, $this->namespace, 'Resource\App'));
        return $schemeCollection;
    }
}