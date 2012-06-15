<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Scope;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DoctrineDbalModule extends AbstractModule
{
    private $masterDb;
    private $slaveDb;
    
    public function __construct(array $masterDb, array $slaveDb)
    {
        $this->masterDb = $masterDb;
        $this->slaveDb = $slaveDb;
        parent::__construct();
    }
    
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind()->annotatedWith('master_db')->toInstance($this->masterDb);
        $this->bind()->annotatedWith('slave_db')->toInstance($this->slaveDb);
        $dbInjector = $this->requestInjection('\BEAR\Framework\Interceptor\DbInjector');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Db'),
            $this->matcher->startWith('on'),
            [$dbInjector]
        );
    }
}
