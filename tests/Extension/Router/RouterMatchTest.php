<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Router;

use PHPUnit\Framework\TestCase;

class RouterMatchTest extends TestCase
{
    public function testToStringWithoutFragment(): void
    {
        $match = new RouterMatch('get', 'page://self/user', ['id' => '1']);

        $this->assertSame('get page://self/user?id=1', (string) $match);
    }

    public function testToStringWithoutFragmentOrQuery(): void
    {
        $match = new RouterMatch('get', 'page://self/user', []);

        $this->assertSame('get page://self/user', (string) $match);
    }

    public function testToStringWithFragmentAndQuery(): void
    {
        $match = new RouterMatch('get', 'page://self/user#link=self:blog', ['id' => '1']);

        $this->assertSame('get page://self/user?id=1#link=self:blog', (string) $match);
    }

    public function testToStringWithFragmentWithoutQuery(): void
    {
        $match = new RouterMatch('get', 'page://self/user#link=self:blog', []);

        $this->assertSame('get page://self/user#link=self:blog', (string) $match);
    }
}
