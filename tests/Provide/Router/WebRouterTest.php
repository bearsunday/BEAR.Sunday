<?php

namespace BEAR\Sunday\Provide\Router;

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
            '_SERVER' => [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/'

            ],
            '_GET' => []
        ];
        $request = $this->router->match($global);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame([], $request->query);
    }

    public function testMatchWithQuery()
    {
        $global = [
            '_SERVER' => [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/?id=1'

            ],
            '_GET' => [
                'id' => 1

            ]
        ];
        $request = $this->router->match($global);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['id' => 1], $request->query);
    }
}
