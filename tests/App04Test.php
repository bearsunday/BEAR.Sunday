<?php

namespace BEAR\Framework;

/**
 * Test class for Annotation.
 */
class App04Test extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->di = require dirname(__DIR__) . '/apps/04-rest/script/di.php';
        $this->resource = $this->di->getInstance('\BEAR\Resource\Client');
    }

    public function testHello()
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

    public function testAopLog()
    {
        $response = $this->resource->get->uri('page://self/aop/log')->withQuery(['lang' => 'en'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello World' . PHP_EOL . '[Log] target = demoWorld\ResourceObject\Greeting\Aop, input = ["en"], result = Hello World' . PHP_EOL, $response->body['greeting']);
    }

    public function testAppHello()
    {
        $response = $this->resource->get->uri('page://self/app/hello')->eager->request();
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

    /**
     * @backupGlobals disabled
     */
    public function testTemplateTwig()
    {
        $response = $this->resource->get->uri('page://self/template/twig')->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Twig', $response->body['greeting']);
    }

    /**
     * @backupGlobals disabled
     */
    public function testHttpSingleRequestPageResource()
    {
        $response = $this->resource->get->uri('page://self/http/googlenews')->eager->request();
        $this->assertSame(200, $response->code);
    }

    public function testHttpMultiRequesPageResource()
    {
        $response = $this->resource->get->uri('page://self/http/multi')->eager->request();
        $this->assertSame(200, $response->code);
    }

    public function testHyplerLinkRestBucks()
    {
        $response = $this->resource->get->uri('page://self/hyperlink/restbucks')->withQuery(['drink' => 'latte'])->eager->request();
        $this->assertSame(200, $response->code);
    }

    public function testHyplerLinkOrder()
    {
        $response = $this->resource->get->uri('page://self/hyperlink/order')->withQuery(['drink' => 'latte'])->eager->request();
        $this->assertSame(200, $response->code);
    }

}