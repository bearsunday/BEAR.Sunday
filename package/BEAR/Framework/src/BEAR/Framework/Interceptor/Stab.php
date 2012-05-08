<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use BEAR\Framework\Inject\LogInject;
use BEAR\Framework\Resource\Ok;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Cache intercepor interface
 *
 * @package    BEAR.Framework
 * @subpackage Interceptor
 */
class Stab implements MethodInterceptor
{
    use LogInject;

    /**
     * Stab data
     *
     * @var mixed
     */
    private $stab;

    /**
     * Constructor
     *
     * @param mixed $stab
     */
    public function __construct($stab)
    {
        $this->stab = $stab;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $object->body = $this->stab;
//         $msg = "stab: " . get_class($invocation->getThis());
// //         $this->log->log($msg);
//         return $this->stab;
//         $result = $invocation->proceed();


//         $result->body = $this->stab;
        return $object;
    }
}