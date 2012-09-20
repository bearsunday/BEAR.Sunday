<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\View;

use Ray\Aop\MethodInterceptor;

/**
 * Json view interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Interceptor
 */
class Json implements MethodInterceptor
{
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        return json_encode($invocation->proceed());
    }
}
