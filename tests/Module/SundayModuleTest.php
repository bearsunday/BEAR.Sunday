<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module;

use BEAR\Resource\Annotation\AppName;
use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Transfer\TransferInterface;
use BEAR\Sunday\Provide\Application\App;
use BEAR\Sunday\Provide\Router\WebRouter;
use BEAR\Sunday\Provide\Transfer\HttpResponder;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class SundayModuleTest extends TestCase
{
    /**
     * @var Injector
     */
    private $injector;

    protected function setUp() : void
    {
        $this->injector = new Injector(new SundayModule(new class extends AbstractModule {
            protected function configure()
            {
                $this->bind()->annotatedWith(AppName::class)->toInstance('BEAR\Sunday');
                $this->bind(AppInterface::class)->to(App::class);
            }
        }));
    }

    public function testMinApp()
    {
        $app = $this->injector->getInstance(AppInterface::class);
        $this->assertInstanceOf(App::class, $app);
    }

    public function testDependModules()
    {
        $cache = $this->injector->getInstance(Cache::class);
        $this->assertInstanceOf(ArrayCache::class, $cache);

        $reader = $this->injector->getInstance(Reader::class);
        $this->assertInstanceOf(Reader::class, $reader);

        $resource = $this->injector->getInstance(ResourceInterface::class);
        $this->assertInstanceOf(ResourceInterface::class, $resource);

        $router = $this->injector->getInstance(RouterInterface::class);
        $this->assertInstanceOf(WebRouter::class, $router);

        $responder = $this->injector->getInstance(TransferInterface::class);
        $this->assertInstanceOf(HttpResponder::class, $responder);
    }
}
