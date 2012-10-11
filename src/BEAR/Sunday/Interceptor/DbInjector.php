<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

use Doctrine\DBAL\DriverManager;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Doctrine\Common\Annotations\AnnotationReader as Reader;


/**
 * Cache interceptor
 *
 * @package    BEAR.Sunday
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
     * @param  array $masterDb
     * @@param array $slaveDb
     *
     * @Inject
     * @Named("masterDb=master_db,slaveDb=slave_db")
     */
    public function __construct(array $masterDb, array $slaveDb)
    {
        $this->masterDb = $masterDb;
        $this->slaveDb = $slaveDb;
    }

    /**
     * Set annotation reader
     *
     * @param Reader $reader
     *
     * @return void
     * @Inject
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $method = $invocation->getMethod();
        $connectionParams = ($method->name !== 'onGet') ? $this->slaveDb : $this->masterDb;
        $pagerAnnotation = $this->reader->getMethodAnnotation($method, 'BEAR\Sunday\Annotation\DbPager');
        if ($pagerAnnotation) {
            $connectionParams['wrapperClass'] = 'BEAR\Sunday\Module\Database\DoctrineDbalModule\Connection';
            $db = DriverManager::getConnection($connectionParams);
            $db->setMaxPerPage($pagerAnnotation->limit);
        } else {
            $db = DriverManager::getConnection($connectionParams);
        }
        /* @var $db \BEAR\Sunday\Module\Database\DoctrineDbalModule\Connection */
        $object->setDb($db);
        $result = $invocation->proceed();
        if ($pagerAnnotation) {
            $pagerData = $db->getPager();
            if ($pagerData) {
                $object->headers['pager'] = $pagerData;
            }
        }

        return $result;
    }
}
