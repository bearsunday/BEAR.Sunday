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
use BEAR\Sunday\Inject\EtagInject;
use Exception;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Cache load interceptor
 *
 * @package    BEAR.Sunday
 * @subpackage Intercetor
 */

class CacheLoader implements MethodInterceptor
{
    use EtagInject;

    /**
     * Cache header key
     *
     * @var string
     */
    const HEADER_CACHE = 'x-cache';

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
        $args = $invocation->getArguments();
        $id = $this->etag->getEtag($ro, $args);

        $pager = (isset($_GET['_start'])) ? $_GET['_start'] : '';
        $saved = $this->cache->fetch($id);
        $pager = (!$pager && isset($saved['pager'])) ? 1 : $pager;
        if ($pager) {
            $pagered = (isset($saved['pager'][$pager])) ? $saved['pager'][$pager] : false;
        } else {
            $pagered = $saved;
        }
        if ($pagered) {
            $resource = $invocation->getThis();
            list($resource->code, $resource->headers, $resource->body) = $pagered;
            $cache = json_decode($resource->headers[self::HEADER_CACHE], true);
            $resource->headers[self::HEADER_CACHE] = json_encode(
                [
                    'mode' => 'R',
                    'date' => $cache['date'],
                    'life' => $cache['life']
                ]
            );

            return $resource;
        }
        $invocation->proceed();
        $resource = $invocation->getThis();
        $time = $invocation->getAnnotation()->time;
        $resource->headers[self::HEADER_CACHE] = json_encode(
            [
                'mode' => 'W',
                'date' => date('r'),
                'life' => $time
            ]
        );
        $data = [$resource->code, $resource->headers, $resource->body];
        if ($pager) {
            $saved['pager'][$pager] = $data;
            $data = $saved;
        }
        try {
            $this->cache->save($id, $data, $time);
        } catch (Exception $e) {
            error_log(get_class($e) . ':' . $e->getMessage());
        }

        return $resource;
    }
}
