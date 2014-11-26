<?php

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class PsrLoggerApplication
{
    use PsrLoggerInject;

    public function returnDependency()
    {
        return $this->logger;
    }
}

class DummyLogger implements LoggerInterface
{
    public function emergency($message, array $context = array())
    {
    }
    public function alert($message, array $context = array())
    {
    }
    public function critical($message, array $context = array())
    {
    }
    public function error($message, array $context = array())
    {
    }
    public function warning($message, array $context = array())
    {
    }
    public function notice($message, array $context = array())
    {
    }
    public function info($message, array $context = array())
    {
    }
    public function debug($message, array $context = array())
    {
    }
    public function log($level, $message, array $context = array())
    {
    }
}

class PsrLoggerModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind('Psr\Log\LoggerInterface')->to(__NAMESPACE__ . '\DummyLogger');
    }
}

class PsrLoggerInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = (new Injector(new PsrLoggerModule))->getInstance(__NAMESPACE__ . '\PsrLoggerApplication');
        $this->assertInstanceOf('\BEAR\Sunday\Inject\DummyLogger', $app->returnDependency());
    }
}
