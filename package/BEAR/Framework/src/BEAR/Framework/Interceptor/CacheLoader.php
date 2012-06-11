<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Guzzle\Common\Cache\Zf2CacheAdapter as CacheAdapter;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;

/**
 * Cache interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
class CacheLoader implements Cachable, MethodInterceptor
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
	 */
	public function __construct(Cache $cache) {
		$this->cache = $cache;
	}

	/**
	 * (non-PHPdoc)
	 * @see Ray\Aop.MethodInterceptor::invoke()
	 */
	public function invoke(MethodInvocation $invocation) {
	    $class = get_class($invocation->getThis());
	    $args = $invocation->getArguments();
		$id = $this->getId($class, $args);
		$saved = $this->cache->fetch($id);
		if ($saved) {
    		$resource = $invocation->getThis();
    		list($resource->code,  $resource->headers, $resource->body) = $saved;
			return $resource;
		}
		$result = $invocation->proceed();
		$resource = $invocation->getThis();
		$resource->headers['x-cached-since'] = date('r');
        $data = [$resource->code, $resource->headers, $resource->body];
		$annotation = $invocation->getAnnotation();
		$time = $annotation->time;
		$this->cache->save($id, $data, $time);
		return $result;
	}

	/**
	 * Return cache id
	 *
	 * @param string $class
	 * @param array  $args
	 *
	 * @return string
	 */
	protected function getId($class, array $args) {
		return $class . crc32(serialize($args));
	}

	/**
	 * (non-PHPdoc)
	 * @see BEAR\Framework\Interceptor\Cachable::delete()
	 */
	public function delete($class, array $args)
	{
	    $id = $this->getId($class, $args);
	    $this->cache->delete($id);
	}

	/**
	 * (non-PHPdoc)
	 * @see BEAR\Framework\Interceptor\Cachable::save()
	 */
	public function save($class, $args, $data)
	{
	    $id = $this->getId($class, $args);
	    $this->cache->save($id, serialize($data), 1);
	}
}
