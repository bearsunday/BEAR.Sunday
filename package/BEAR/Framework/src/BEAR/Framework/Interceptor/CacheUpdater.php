<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use BEAR\Framework\Framework;

use Aura\Signal\Manager as Signal;
use BEAR\Framework\Interceptor\CacheInterface as CacheInterceptor;
use BEAR\Resource\Invoker;
use BEAR\Resource\Request;
use BEAR\Resource\Linker;
use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Aura\Signal\Manager;
use Aura\Signal\HandlerFactory;
use Aura\Signal\ResultFactory;
use Aura\Signal\ResultCollection;
/**
 * Cache update interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
class CacheUpdater implements MethodInterceptor
{
    /**
     * Constructor
     *
     * @param CacheInterceptor $cache
     */
    public function __construct(CacheInterceptor $cache, Request $request = null)
    {
        $this->cache = $cache;
        $this->request = $request ?: new Request(new Invoker(new Config(new Annotation(new Definition)), new Linker, new Manager(new HandlerFactory, new ResultFactory, new ResultCollection)));
    }

    /**
     * @param Request $request
     *
     * @return void
     * Inject
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $invocationArgs = $invocation->getArguments();
        $annotation = $invocation->getAnnotation();
        $args = [];
        $method = $invocation->getMethod();
        $parameters = $method->getParameters();
        foreach ($parameters as $parameter) {
            if (in_array($parameter->name, $annotation->args)) {
                $args[$parameter->name] = $invocationArgs[$parameter->getPosition()];
            }
        }
        $object = $invocation->getThis();
        // call @Get
        $request = $this->request;
        $request->ro = $object;
        $request->method  = 'get';
        $data = $request($args);
        $class = get_class($invocation->getThis());
        // save cahce
        $this->cache->delete($class, $args);
        // call original @CacheUpdate annotated method
        return $invocation->proceed();
    }
}
