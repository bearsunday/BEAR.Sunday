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
use Guzzle\Common\Cache\CacheAdapterInterface;
use ReflectionMethod;
use BEAR\Sunday\Inject\EtagInject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


/**
 * Cache update interceptor
 *
 * @package    BEAR.Sunday
 * @subpackage Intercetor
 */
class CacheUpdater implements MethodInterceptor
{
    use EtagInject;

    /**
     * Constructor
     *
     * @param CacheAdapterInterface $cache
     *
     * @Inject
     * @Named("resource_cache")
     */
    public function __construct(CacheAdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $ro = $invocation->getThis();

        // onGet(void) clear cache
        $id = $this->etag->getEtag($ro, [0 => null]);
        $this->cache->delete($id);

        // onGet($id, $x, $y...) clear cache
        $getMethod = new ReflectionMethod($ro, 'onGet');
        $parameterNum = count($getMethod->getParameters());
        // cut as same size and order as onGet
        $slicedInvocationArgs = array_slice($invocation->getArguments(), 0, $parameterNum);
        $id = $this->etag->getEtag($ro, $slicedInvocationArgs);
        $this->cache->delete($id);

        return $invocation->proceed();
    }
}
