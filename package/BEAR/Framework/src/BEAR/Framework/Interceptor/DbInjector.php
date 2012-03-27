<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor,
Ray\Aop\MethodInvocation;
use Doctrine\DBAL\DriverManager;

/**
 * Cache interceptor
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class DbInjector implements MethodInterceptor
{
    /**
     * DSN for master
     *
     * @var array
     */
    private $masterDsn;

    /**
     * DSN for slave
     *
     * @var array
     */
    private $slaveDsn;

    /**
     * Constructor
     *
     * @Inject
     * @Named("masterDb=master_db,slaveDb=slave_db")
     */
    public function setDsn(array $masterDb, array $slaveDb) {
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
