<?php

namespace BEAR\Sunday\Tests;

use BEAR\Sunday\Framework\Framework;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use BEAR\Sunday\Interceptor\CacheUpdater;
use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ArrayCache as CacheStorage;
use Ray\Aop\ReflectiveMethodInvocation;
use BEAR\Sunday\Annotation\CacheUpdate;
use BEAR\Sunday\Resource\CacheControl\Etag;
use Doctrine\Common\Annotations\AnnotationReader as Reader;


require_once dirname(__DIR__) . '/Mock/ResourceObject/MockResource.php';

class CacheUpdaterTest extends \PHPUnit_Framework_TestCase
{
    private $cahce;
    private $etag;

    protected function setUp()
    {
        parent::setUp();
        $this->cache = new CacheAdapter(new CacheStorage);
        $config = new Config(new Annotation(new Definition, new Reader));
        $this->cacheUpdater = (new CacheUpdater($this->cache, $config));
        $this->etag = new Etag;
        $this->cacheUpdater->setEtag($this->etag);
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Sunday\Interceptor\CacheUpdater', $this->cacheUpdater);
    }

    public function test_invoke()
    {
        $ro = new \tests\Mock\ResourceObject\MockResource;
        $args = [];
        $interceptors = [$this->cacheUpdater];
        $annotation = new CacheUpdate;
        $annotation->args = [];
        $invocation = new ReflectiveMethodInvocation([$ro, 'onPost'], $args, $interceptors, $annotation);

        $id = $this->etag->getEtag($ro, $args);
        $cacheData = "cache_data";
        $this->cache->save($id, $cacheData);
        $contents = $this->cache->fetch($id);
        $this->assertSame($contents, $cacheData);
        $result = $this->cacheUpdater->invoke($invocation);
        $contents = $this->cache->fetch($id);
        $this->assertSame($contents, false);
    }
}
