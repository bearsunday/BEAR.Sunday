<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use BEAR\Framework\Interceptor\ViewAdapter\Renderable;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Cache interceptor
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class ViewAdapter implements MethodInterceptor
{
    /**
     * Constructor
     */
    public function __construct(Renderable $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation) {
        $resource = $invocation->proceed();
        $paegFile = (new \ReflectionClass($resource))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->renderer->assign('resource', $resource);
        if (is_array($resource->body) || $resource->body instanceof \Traversable) {
            $this->renderer->assign($resource->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
        $resource->body = $this->renderer->fetch($templateFileBase);

        return $resource;
    }
}
