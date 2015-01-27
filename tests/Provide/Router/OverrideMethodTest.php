<?php

namespace BEAR\Sunday\Provide\Router;

require __DIR__ . '/file_get_contents.php';

class OverrideMethodTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $server = ['REQUEST_METHOD' => 'GET'];
        $get = ['id' => '1'];
        $post = [];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('get', $method);
        $this->assertSame(['id' => '1'], $params);
    }

    public function testPost()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = [];
        $post = ['id' => '1'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('post', $method);
        $this->assertSame(['id' => '1'], $params);
    }

    public function testPut()
    {
        $server = ['REQUEST_METHOD' => 'PUT'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('put', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testPatch()
    {
        $server = ['REQUEST_METHOD' => 'PATCH'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('patch', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testDelete()
    {
        $server = ['REQUEST_METHOD' => 'DELETE'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('delete', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testOverridePut()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday', '_method' => 'PUT'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('put', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }

    public function testOverridePatch()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday', '_method' => 'PATCH'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('patch', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }

    public function testOverrideDelete()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday', '_method' => 'DELETE'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('delete', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }

    public function testOverrideHeaderPut()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('put', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }

    public function testOverrideHeaderPatch()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PATCH'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('patch', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }

    public function testOverrideHeaderDelete()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'DELETE'];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new OverrideMethod)->get($server, $get, $post);
        $this->assertSame('delete', $method);
        $this->assertSame(['name' => 'sunday'], $params);
    }
}
