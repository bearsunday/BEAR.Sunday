<?php
namespace sandbox\Interceptor;

use Ray\Aop\MethodInterceptor,
    Ray\Aop\MethodInvocation;

/**
 * Log Interceptor
 */
class Log implements MethodInterceptor
{
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();
        $class = get_class($invocation->getThis());
        $input = $invocation->getArguments();
        $input = json_encode($input);
        $result .= PHP_EOL .  "[Log] target = $class, input = $input, result = $result" . PHP_EOL;
        return $result;
    }
}
