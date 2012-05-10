<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use BEAR\Framework\Inject\LogInject;

/**
 * Log Interceptor
 *
 * @package    BEAR.Framework
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
        $input = $invocation->getArguments();
        $input = substr(json_encode($input), 0 ,80);
        $output = substr(json_encode($result), 0 ,80);
        $log = "target = [{$class}], input = [{$input}], result = [{$output}]";
        $this->log->log($log);
        return $result;
    }
}
