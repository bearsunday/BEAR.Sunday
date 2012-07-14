<?php
/**
 * Env setting checker
 *
 * @package BEAR.Framework
 */
namespace sandbox\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Interceptor
 */
class TimeMessage implements MethodInterceptor
{
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $time = date('g:i');
        $result = $invocation->proceed() . ". It is {$time} now !";
        return $result;
    }
}
