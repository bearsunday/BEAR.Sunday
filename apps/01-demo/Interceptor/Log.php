<?php
namespace demoWorld\Interceptor;

use Ray\Aop\MethodInterceptor,
    Ray\Aop\MethodInvocation;

/**
 * Log Interceptor
 */
class Log implements MethodInterceptor
{
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
