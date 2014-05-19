<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\LoggerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use BEAR\Resource\Logger;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class ResourceLoggerTestModule extends AbstractModule
{
    protected function configure()
    {
//        $this->bind('BEAR\Resource\LoggerInterface')->to('BEAR\Resource\Logger');
        $this->bind('BEAR\Resource\LoggerInterface')->annotatedWith('resource_logger')->toProvider('BEAR\Sunday\Module\Resource\ResourceLoggerProvider');
    }
}

class Consumer
{
    public $logger;

    /**
     * @Inject
     * @Named("resource_logger")
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

class ResourceLoggerProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $loggerProvider = new ResourceLoggerProvider;
        $loggerProvider->setResourceLogger(new Logger);
        $logger = $loggerProvider->get();

        $this->assertInstanceOf('BEAR\Resource\LoggerInterface', $logger);

        return $logger;
    }

    /**
     * @param LoggerInterface        $logger
     * @param ResourceLoggerProvider $loggerProvider
     *
     * @depends testGetInstance
     */
    public function testSingleton($logger)
    {
        $loggerProvider = new ResourceLoggerProvider;
        $loggerProvider->setResourceLogger(new Logger);
        $anotherLogger = $loggerProvider->get();
        $this->assertSame(spl_object_hash($logger), spl_object_hash($anotherLogger));
    }
}
