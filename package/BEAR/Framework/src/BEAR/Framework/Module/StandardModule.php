<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface as Di;
use Ray\Di\Scope;
use BEAR\Framework\AbstractAppContext as App;

/**
 * Framework default module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class StandardModule extends AbstractModule
{
    /**
     * Injector
     *
     * @var Inject
     */
    private $injector;

    /**
     * Constructor
     *
     * @param Inject $injector
     * @param string $appName application name (= _NAMESPACE_)
     */
    public function __construct(Di $injector)
    {
        $this->injector = $injector;
        $this->config = $injector->getContainer()->getForge()->getConfig();
//         $this->app = $app;
        parent::__constrrcut();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->injector);
        $this->bind('Aura\Di\ConfigInterface')->toInstance($this->config);
<<<<<<< Updated upstream
        $this->bind('BEAR\Resource\Resource')->to('BEAR\Resource\Client')->in(Scope::SINGLETON);
=======
        $this->bind('BEAR\Resource\ResourceInterface')->to('BEAR\Resource\Resource')->in(Scope::SINGLETON);
>>>>>>> Stashed changes
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\Invoker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\LinkerInterface')->to('BEAR\Resource\Linker')->in(Scope::SINGLETON);
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Framework\Module\Provider\CacheProvider')->in(Scope::SINGLETON);
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Framework\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\ResourceInterface')->toProvider('BEAR\Framework\Module\Provier\ResourceClientProvider');
//         $this->bind('BEAR\Framework\AbstractAppContext')->toInstance($this->app);
    }
}
