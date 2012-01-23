<?php
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor,
    Ray\Aop\MethodInvocation;

/**
 * Transaction interceptor
 */
class Transactional implements MethodInterceptor
{
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $ref = new \ReflectionProperty($object, 'db');
        $ref->setAccessible(true);
        $db = $ref->getValue($object);
        $db->beginTransaction();
        try {
            $invocation->proceed();
            $db->commit();
        } catch (\Exception $e) {
            $db->roleback();
        }
    }
}
