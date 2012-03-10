<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor,
Ray\Aop\MethodInvocation;

use Guzzle\Common\Cache\ZendCacheAdapter as Cacheable;

/**
 * Cache interceptor
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class Cache implements MethodInterceptor
{
    /**
     * Host
     *
     * @var string
     */
    private $host;

    /**
     * Life time
     *
     * @var int
     */
    private $lifeTime;

    /**
     * Constructor
     *
     * @param Cache $cache
     * @param unknown_type $lifeTime
     */
    public function __construct(Cacheable $cache)
    {
        $this->cache = $cache;
    }

    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        $id = $this->getId($invocation, $invocation->getArguments());
        $saved = $this->cache->fetch($id);
        if ($saved) {
            return unserialize($saved);
        }
        $data = $invocation->proceed();
        $annotation = $invocation->getAnnotation();
        $time = $annotation->time;
        $r = $this->cache->save($id, serialize($data), $time);
        return $data;
    }

    /**
     * Return cache id
     *
     * @param MethodInvocation $invocation
     * @param array $args
     */
    protected function getId(MethodInvocation $invocation, $args)
    {
        $class = get_class($invocation->getThis());
        $method = $invocation->getMethod()->name;
        return $method . crc32($class . (serialize($args)));
    }
}
