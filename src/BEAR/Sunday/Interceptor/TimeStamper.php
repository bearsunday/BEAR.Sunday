<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Log Interceptor
 *
 * @package    BEAR.Sunday
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
        /** @noinspection PhpUndefinedFieldInspection */
        $object->time = date("Y-m-d H:i:s", time());
        $result = $invocation->proceed();

        return $result;
    }
}
