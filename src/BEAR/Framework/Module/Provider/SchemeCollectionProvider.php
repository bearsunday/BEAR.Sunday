<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use BEAR\Resource\Adapter\App;
use BEAR\Resource\Adapter\Http;
use BEAR\Resource\SchemeCollection;
use BEAR\Framework\AbstractAppContext as AppContext;
use Ray\Di\InjectorInterface as Di;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Application resource module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SchemeCollectionProvider implements Provide
{
    /**
     * Constructor
     *
     * @param Di $injector
     *
     * @Inject
     */
    public function __construct(Di $injector)
    {
        $this->injector = $injector;
    }

    /**
     * Set app name
     *
     * @param string $appName
     *
     * @Inject
     * @Named("app_name")
     */
    public function setAppName($appName)
    {
        $this->namespace = $appName;
    }

    /**
     * Set helloworld application dependency injector
     *
     * @param Di $injector
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
        $schemeCollection->scheme('app')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'Resource\App'));
        $schemeCollection->scheme('page')->host('self')->toAdapter(new App($this->injector, $this->namespace, 'Resource\Page'));
//         $schemeCollection->scheme('page')->host('helloworld')->toAdapter(new App($this->helloInjector, 'helloworld', 'Resource\Page'));
        $schemeCollection->scheme('http')->host('*')->toAdapter(new Http);

        return $schemeCollection;
    }
}
