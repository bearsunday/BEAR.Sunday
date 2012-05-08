<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Doctrine\DBAL\DriverManager;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Cache interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
class DbInjector implements MethodInterceptor
{
    /**
     * DSN for master
     *
     * @var array
     */
    private $masterDb;

    /**
     * DSN for slave
     *
     * @var array
     */
    private $slaveDb;

    /**
     * Constructor
     *
     * @Inject
     * @Named("masterDb=master_db,slaveDb=slave_db")
     */
    public function __construct(array $masterDb, array $slaveDb) {
        $this->masterDb = $masterDb;
        $this->slaveDb = $slaveDb;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation) {
        $object = $invocation->getThis();
        $method = $invocation->getMethod();
        $connectionParams = ($method->name !== 'onGet') ? $this->slaveDb : $this->masterDb;
        $db = DriverManager::getConnection($connectionParams);
        $object->setDb($db);
        return $invocation->proceed();
    }
}
