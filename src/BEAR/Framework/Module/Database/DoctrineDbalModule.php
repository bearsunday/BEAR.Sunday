<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database;

use Ray\Di\InjectorInterface;
use Ray\Di\AbstractModule;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DoctrineDbalModule extends AbstractModule
{
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
        $dbInjector = $this->injector->getInstance('\BEAR\Framework\Interceptor\DbInjector');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Db'),
            $this->matcher->startWith('on'),
            [$dbInjector]
        );
    }
}
