<?php

namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Module\Cqrs\Interceptor\CacheLoader;
use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ArrayCache as CacheStorage;
use Ray\Aop\ReflectiveMethodInvocation;
use BEAR\Sunday\Annotation\Cache as CacheAnnotation;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use BEAR\Sunday\Module\Mock\ResourceObject\MockResource;

class CacheLoaderTest extends \PHPUnit_Framework_TestCase
{
    private $cacheLoader;

    protected function setUp()
    {
        parent::setUp();
        $this->cache = new CacheAdapter(new CacheStorage);
        $config = new Config(new Annotation(new Definition, new Reader));
        $this->cacheLoader = (new CacheLoader($this->cache, $config));
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Sunday\Module\Cqrs\Interceptor\CacheLoader', $this->cacheLoader);
    }

    public function test_invoke()
    {
        $ro = new MockResource;
        $args = [];
        $interceptors = [$this->cacheLoader];
        $annotation = new CacheAnnotation;
        $annotation->args = [];
        $invocation = new ReflectiveMethodInvocation([$ro, 'onGet'], $args, $interceptors, $annotation);
        $result = $this->cacheLoader->invoke($invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }
}
