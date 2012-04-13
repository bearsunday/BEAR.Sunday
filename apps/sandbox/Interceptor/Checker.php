<?php
namespace sandbox\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\AbstractModule;

/**
 * Log Interceptor
 */
class Checker implements MethodInterceptor
{
    private $tmpDir;

    /**
     * Constructor
     *
     * @param string $tmpDir
     * @Inject
     * @Named("tmp_dir")
     */
    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        if (is_writable($this->tmpDir)) {
            return $invocation->proceed();
        }
        $pageObject = $invocation->getThis();
        $tmpDir = $this->tmpDir;
        $pageObject->representation  =  include __DIR__ . '/Checker/error.php';
        return $pageObject;
    }
}
