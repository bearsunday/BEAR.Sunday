<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Log Interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Interceptor
 */
class TimeStamper implements MethodInterceptor
{
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $object->time = date("Y-m-d H:i:s", time());
        $result = $invocation->proceed();

        return $result;
    }
}
