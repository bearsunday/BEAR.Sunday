<?php

namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Module\Cqrs\Interceptor\CacheUpdater;
use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ArrayCache as CacheStorage;
use Ray\Aop\ReflectiveMethodInvocation;
use BEAR\Sunday\Annotation\CacheUpdate;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use BEAR\Sunday\Module\Mock\ResourceObject\MockResource;

class CacheUpdaterTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->cache = new CacheAdapter(new CacheStorage);
        $config = new Config(new Annotation(new Definition, new Reader));
        $this->cacheUpdater = (new CacheUpdater($this->cache, $config));
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Sunday\Module\Cqrs\Interceptor\CacheUpdater', $this->cacheUpdater);
    }

    public function test_invoke()
    {
        $ro = new MockResource;
        $args = [];
        $interceptors = [$this->cacheUpdater];
        $annotation = new CacheUpdate;
        $annotation->args = [];
        $invocation = new ReflectiveMethodInvocation([$ro, 'onPost'], $args, $interceptors, $annotation);

        $id = $this->cacheUpdater->getEtag($ro, $args);
        $cacheData = "cache_data";
        $this->cache->save($id, $cacheData);
        $contents = $this->cache->fetch($id);
        $this->assertSame($contents, $cacheData);
        $this->cacheUpdater->invoke($invocation);
        $contents = $this->cache->fetch($id);
        $this->assertSame($contents, false);
    }
}
