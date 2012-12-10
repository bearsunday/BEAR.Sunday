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
use BEAR\Sunday\Inject\LogInject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Log Interceptor
 *
 * @package    BEAR.Sunday
 * @subpackage Interceptor
 */
class Logger implements MethodInterceptor
{
    use LogInject;

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();
        $class = get_class($invocation->getThis());
        $object = $invocation->getThis();
        $args = $invocation->getArguments();
        $object->headers['x-args'] = json_encode($args);
        $input = substr(json_encode($args), 0, 80);
        $output = substr(json_encode($result), 0, 80);
        $log = "target = [{$class}], input = [{$input}], result = [{$output}]";
        $this->log->log($log);

        return $result;
    }
}
