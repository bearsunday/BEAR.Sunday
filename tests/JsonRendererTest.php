<?php

namespace BEAR\Framework\Tests;

use Ray\Di\Config;
use Ray\Di\Annotation;
use Ray\Di\Definition;
use BEAR\Resource\Request;
use BEAR\Resource\Linker;
use BEAR\Resource\Invoker;
use BEAR\Framework\Resource\Ok;
use BEAR\Framework\Resource\View\JsonRenderer;
use Doctrine\Common\Annotations\AnnotationReader as Reader;

class RequestSample
{
    public function __toString()
    {
        return __CLASS__;
    }
}

/**
 * Test class for JsonRenderer.
 */
class JsonRendererTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $signal = require dirname(__DIR__) . '/vendor/Aura/Signal/scripts/instance.php';
        $request = new Request(new Invoker(new Config(new Annotation(new Definition)), new Linker(new Reader), $signal));
        $request->method = 'get';
        $this->testResource = new Ok;
        $request->ro = $this->testResource;
        $request->ro->uri = 'test://self/path/to/resource';

        $this->testResource['one'] = 1;
        $this->testResource['two'] = $request;
        $this->testResource->setRenderer(new JsonRenderer);
    }

    public function test_render()
    {
        // json render
        $result = (string) $this->testResource;
        $data = json_decode($result, true);
        $expected = array (
  'one' => 1,
  'two' =>
  array (
    'code' => 200,
    'headers' =>
    array (
    ),
    'body' =>
    array (
      'one' => 1,
      'two' => NULL,
    ),
    'uri' => 'test://self/path/to/resource',
    'view' => NULL,
  ),
);
        $this->assertSame($expected, $data);
    }
}
