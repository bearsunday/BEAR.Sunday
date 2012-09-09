<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Cqrs;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
use Guzzle\Common\Cache\CacheAdapterInterface;

/**
 * Cache module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CacheModule extends AbstractModule
{
    /**
     * @var CacheAdapterInterface
     */
    private $injector;

    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cacheLoader = $this->injector->getInstance('BEAR\Framework\Interceptor\CacheLoader');
        // bind @Cache annotatated method in any class
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
            [$cacheLoader]
        );
        $cacheUpdater = $this->injector->getInstance('BEAR\Framework\Interceptor\CacheUpdater');
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\CacheUpdate'),
            [$cacheUpdater]
        );
    }
}
