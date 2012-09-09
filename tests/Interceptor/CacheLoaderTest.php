<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Framework;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use BEAR\Framework\Interceptor\CacheLoader;
use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ArrayCache as CacheStorage;
use Ray\Aop\ReflectiveMethodInvocation;
use BEAR\Framework\Annotation\Cache as CacheAnnotation;
use BEAR\Framework\Resource\CacheControl\Etag;

require_once dirname(__DIR__) . '/Mock/ResourceObject/MockResource.php';

class CacheLoaderTest extends \PHPUnit_Framework_TestCase
{
    private $cahce;
    private $etag;
    private $cacheLoader;

    protected function setUp()
    {
        parent::setUp();
        $this->cache = new CacheAdapter(new CacheStorage);
        $config = new Config(new Annotation(new Definition));
        $this->cacheLoader = (new CacheLoader($this->cache, $config));
        $this->etag = new Etag;
        $this->cacheLoader->setEtag($this->etag);
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Framework\Interceptor\CacheLoader', $this->cacheLoader);
    }

    public function test_invoke()
    {
        $ro = new \tests\Mock\ResourceObject\MockResource;
        $args = [];
        $interceptors = [$this->cacheLoader];
        $annotation = new CacheAnnotation;
        $annotation->args = [];
        $invocation = new ReflectiveMethodInvocation([$ro, 'onGet'], $args, $interceptors, $annotation);
        $result = $this->cacheLoader->invoke($invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }
}
