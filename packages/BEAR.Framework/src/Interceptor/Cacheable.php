<?php
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor,
    Ray\Aop\MethodInvocation;
use Doctrine\Common\Cache\Cache,
    Doctrine\Common\Cache\MemcacheCache;
/**
 * Cacheable interceptor
 */
class Cacheable implements MethodInterceptor
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
    public function __construct(Cache $cache, $appName, $lifeTime = 0, $host = 'locahost')
    {
        $cache->setNamespace($appName);
        $this->cache = $cache;
        $this->host = $host;
        $this->lifeTime = $lifeTime;
    }

    /**
     * Create memchace property in runtime init
     *
     */
    public function __wakeup()
    {
        $memcahce = new \Memcache;
        $memcahce->connect($this->host);
        $this->cache->setMemcache($memcahce);
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
            return $saved;
        }
        $data = $invocation->proceed();
        $this->cache->save($id, $data, $this->lifeTime);
        $saved = $this->cache->fetch($id);
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
        return $class . $method . md5(serialize($args));
    }
}
