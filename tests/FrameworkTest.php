<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Framework;
use mockapp\App;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;
use Zend\Cache\Backend\File as CacheBackEnd;


/**
 * Test class for Annotation.
 */
class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->framework = new Framework;
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Framework\Framework', $this->framework);
    }

    /**
     * loader already set, no error triggerd.
     */
    public function test_NewSecond()
    {
        $this->assertInstanceOf('BEAR\Framework\Framework', $this->framework);
    }

    public function test_setCache()
    {
        $this->framework->setCache(new CacheAdapter(new CacheBackEnd));
        $this->assertInstanceOf('BEAR\Framework\Framework', $this->framework);
    }

}
