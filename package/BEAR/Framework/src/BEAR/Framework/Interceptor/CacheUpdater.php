<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;
use Aura\Signal\Manager as Signal;
use Ray\Aop\MethodInterceptor,
    Ray\Aop\MethodInvocation;
use BEAR\Framework\Interceptor\Cachable as CacheInterceptor;
use BEAR\Resource\Invoker;
use BEAR\Resource\Request;
use BEAR\Resource\Linker;
use Ray\Di\Config,
    Ray\Di\Annotation,
    Ray\Di\Definition;

/**
 * Cache update interceptor
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
        $signal = require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/vendor/Aura/Signal/scripts/instance.php';
        $this->request = $request ?: new Request(new Invoker(new Config(new Annotation(new Definition)), new Linker, $signal));
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
//         $this->cache->save($class, $args, $data);
        $this->cache->delete($class, $args);
        // call original @CacheUpdate annotated method
        return $invocation->proceed();
    }
}
