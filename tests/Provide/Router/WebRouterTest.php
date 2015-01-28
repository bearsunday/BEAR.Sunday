<?php

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Extension\Router\SchemeHost;

class WebRouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WebRouter
     */
    private $router;

    public function setUp()
    {
        parent::setUp();
        $this->router = new WebRouter;
    }

    public function testMatchRoot()
    {
        $global = [
            '_GET' => []
        ];
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/'

        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame([], $request->query);
    }

    public function testMatchWithQuery()
    {
        $global = [
            '_GET' => [
                'id' => 1

            ]
        ];
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/?id=1'
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['id' => 1], $request->query);
    }

    public function testSchemeHost()
    {
        $global = [
            '_GET' => []
        ];
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/'

        ];
        $this->router->setSchemeHost(new SchemeHost('app://self'));
        $request = $this->router->match($global, $server);
        $this->assertSame('app://self/', $request->path);

    }
    public function testGenerate()
    {
        $actual = $this->router->generate('', []);
        $this->assertFalse($actual);
    }
}
