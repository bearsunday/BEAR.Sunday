<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cqrs\Interceptor;

use Guzzle\Cache\CacheAdapterInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
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
    use EtagTrait;

    private $pagerKey = '_start';

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
     * @param $pagerKey
     *
     * @return $this
     * @Inject(optional=true)
     * @Named("pager_key")
     */
    public function setPagerQueryKey($pagerKey)
    {
        $this->pagerKey = $pagerKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $ro = $invocation->getThis();
        /** @var $ro \BEAR\Resource\AbstractObject */
        $args = $invocation->getArguments();
        $id = $this->getEtag($ro, $args);
        $ro->headers['Tag'] = $id;
        $saved = $this->cache->fetch($id);
        $pagerNum = $this->getPagerNum($saved);
        if ($pagerNum) {
            $saved = (isset($saved['pager'][$pagerNum])) ? $saved['pager'][$pagerNum] : false;
        }
        if ($saved) {
            return $this->getSavedResource($invocation, $saved);
        }

        return $this->save($invocation, $pagerNum, $id);
    }

    /**
     * @param $saved
     *
     * @return bool|int
     */
    private function getPagerNum($saved)
    {
        if (isset($_GET[$this->pagerKey])) {
            $pagerNum = $_GET[$this->pagerKey];
        } elseif (isset($saved['pager'])) {
            $pagerNum = 1;
        } else {
            $pagerNum = false;
        }

        return $pagerNum;
    }

    /**
     * @param MethodInvocation $invocation
     * @param mixed            $saved
     *
     * @return object
     */
    private function getSavedResource(MethodInvocation $invocation, $saved)
    {
        $resource = $invocation->getThis();
        list($resource->code, $resource->headers, $resource->body) = $saved;
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

    /**
     * @param MethodInvocation $invocation
     * @param int              $pagerNum
     * @param string           $id
     *
     * @return object
     */
    private function save(MethodInvocation $invocation, $pagerNum, $id)
    {
        $invocation->proceed();
        $resource = $invocation->getThis();
        $time = $this->getSaveTime($invocation);
        $resource->headers[self::HEADER_CACHE] = json_encode(
            [
                'mode' => 'W',
                'date' => date('r'),
                'life' => $time
            ]
        );
        $data = [$resource->code, $resource->headers, $resource->body];
        if ($pagerNum) {
            $saved['pager'][$pagerNum] = $data;
            $data = $saved;
        }
        $this->cache->save($id, $data, $time);

        return $resource;
    }

    /**
     * @param MethodInvocation $invocation
     *
     * @return int
     */
    protected function getSaveTime(MethodInvocation $invocation)
    {
        $time = $invocation->getAnnotation()->time;

        return $time;
    }
}
