<?php

namespace BEAR\Framework\Tests;

/**
 * Test class for Annotation.
 */
class demoworldTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->di = require dirname(__DIR__) . '/apps/demoworld/scripts/di.php';
        $this->resource = $this->di->getInstance('\BEAR\Resource\Client');
    }

    public function testHelloOnly()
    {
        $response = $this->resource->get->uri('page://self/hello')->withQuery(['lang' => 'en'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello World', $response->body['greeting']);
    }

    public function testHelloResource()
    {
        $response = $this->resource->get->uri('page://self/helloresource')->withQuery(['lang' => 'ja'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Konichiwa Sekai', $response->body['greeting']);
    }

    public function atestAopLog()
    {
        $r = $this->resource->get->uri('page://self/aop/log')->withQuery(['lang' => 'en'])->request();
        $response = $this->resource->get->uri('page://self/aop/log')->withQuery(['lang' => 'en'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello World' . PHP_EOL . '[Log] target = demoworld\ResourceObject\Greeting\Aop, input = ["en"], result = Hello World' . PHP_EOL, $response->body['greeting']);
    }

    public function testAppHello()
    {
        $response = $this->resource->get->uri('page://self/app/Hello')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello another app', $response->body['greeting']->body);
    }

    public function testTemplateHaanga()
    {
        $response = $this->resource->get->uri('page://self/template/haanga')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Haanga', $response->body['greeting']);
    }

    public function testTemplatePhp()
    {
        $response = $this->resource->get->uri('page://self/template/php')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello World', $response->body['greeting']);
    }

    public function testTemplateSmarty3()
    {
        $response = $this->resource->get->uri('page://self/template/smarty3')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Smarty3', $response->body['greeting']);
    }

    public function testTemplateTwig()
    {
        $response = $this->resource->get->uri('page://self/template/twig')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Twig', $response->body['greeting']);
    }

    public function testHttpSingleRequestPageResource()
    {
        $response = $this->resource->get->uri('page://self/http/googlenews')->eager->request();
        $this->assertSame(200, $response->code);
    }

    public function ____testHttpMultiRequesPageResource()
    {
        $response = $this->resource->get->uri('page://self/http/multi')->eager->request();
        $this->assertSame(200, $response->code);
    }

    public function testHyplerLinkRestBucks()
    {
        $response = $this->resource->get->uri('page://self/hyperlink/restbucks')->withQuery(['drink' => 'latte'])->eager->request();
        $this->assertSame(200, $response->code);
    }

    /**
     * @medium
     */
    public function testHyplerLinkOrder()
    {
        $response = $this->resource->get->uri('page://self/hyperlink/order')->withQuery(['drink' => 'latte'])->eager->request();
        $this->assertSame(200, $response->code);
    }

}
