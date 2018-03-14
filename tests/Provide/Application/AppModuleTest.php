<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Application;

use BEAR\Sunday\Extension\Application\AppInterface;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class AppModuleTest extends TestCase
{
    public function testApp()
    {
        $app = (new Injector(new AppModule))->getInstance(AppInterface::class);
        $this->assertInstanceOf(MinApp::class, $app);
    }
}
