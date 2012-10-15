<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

use BEAR\Sunday\Inject\LogInject;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;

/**
 * Cache interceptor interface
 *
 * @package    BEAR.Sunday
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
        if (is_array($object->body)) {
            $object->body = array_merge($object->body, $this->stab);
        } else {
            $object->body = $this->stab;
        }
        return $object;
    }
}
