<?php

namespace BEAR\Sunday\Module\Cache;

use BEAR\Resource\AbstractObject;
use BEAR\Sunday\Annotation\Cache as CacheAnnotation;
use BEAR\Sunday\Module\Cqrs\Interceptor\CacheLoader;
use BEAR\Sunday\Module\Mock\ResourceObject\MockResource;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\PhpFileCache;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Aop\ReflectiveMethodInvocation;
use Ray\Di\Definition;

class CacheLoaderTest extends \PHPUnit_Framework_TestCase
{
    const TIME = 10;

    /**
     * @var CacheAdapter
     */
    private $cacheAdapter;

    /**
     * @var CacheLoader
     */
    private $cacheLoader;

    /**
     * @var ReflectiveMethodInvocation
     */
    private $invocation;

    protected function setUp()
    {
        parent::setUp();
        $this->cacheLoader = (new CacheLoader(new CacheAdapter(new ArrayCache)));
        $cacheAnnotation = new CacheAnnotation;
        $cacheAnnotation->time = self::TIME;
        $this->invocation = new ReflectiveMethodInvocation([new MockResource, 'onGet'], [], [$this->cacheLoader], $cacheAnnotation);
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Sunday\Module\Cqrs\Interceptor\CacheLoader', $this->cacheLoader);
    }

    public function testInvokeWrite()
    {
        $result = $this->cacheLoader->invoke($this->invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }

    public function testInvokeRead()
    {
        $this->cacheLoader->invoke($this->invocation);
        $result = $this->cacheLoader->invoke($this->invocation);
        $this->assertTrue(isset($result->headers['x-cache']));

        return $result;
    }

    /**
     * @depends testInvokeRead
     *
     * @param AbstractObject $ro
     */
    public function testInvokeReadMode(AbstractObject $result)
    {
        $cacheInfo = json_decode($result->headers['x-cache']);
        $this->assertSame('R', $cacheInfo->mode);
    }

    /**
     * @depends testInvokeRead
     *
     * @param AbstractObject $ro
     */
    public function testInvokeReadLife(AbstractObject $result)
    {
        $cacheInfo = json_decode($result->headers['x-cache']);
        $this->assertSame(self::TIME, $cacheInfo->life);
    }

    public function testInvokeWriteWithPagerQuery()
    {
        $_GET['_start'] = 1;
        $result = $this->cacheLoader->invoke($this->invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }
    public function testInvokeWritePagerData()
    {
        $this->cacheLoader = (new CacheLoader(new CacheAdapter(new ArrayCache)));
        $_GET['_start'] = 1;
        $result = $this->cacheLoader->invoke($this->invocation);
        unset($_GET['_start']);
        $result = $this->cacheLoader->invoke($this->invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }

    public function testInvokeSetPagerKey()
    {
        $this->cacheLoader = (new CacheLoader(new CacheAdapter(new ArrayCache)))->setPagerQueryKey('page');
        $result = $this->cacheLoader->invoke($this->invocation);
        $this->assertTrue(isset($result->headers['x-cache']));
    }
}
