<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Router;

use PHPUnit\Framework\TestCase;

class WebRouterTest extends TestCase
{
    /**
     * @var WebRouter
     */
    private $router;

    public function setUp()
    {
        parent::setUp();
        $this->router = new WebRouter('page://self');
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

    public function testGenerate()
    {
        $actual = $this->router->generate('', []);
        $this->assertFalse($actual);
    }
}
