<?php

namespace BEAR\Sunday\Module\WebContext;

use BEAR\Sunday\Module\WebContext\AuraWebModule;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Inject;

class Application
{
    /**
     * @var ProviderInterface
     */
    public $web;

    /**
     * @param ProviderInterface $web
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("webContext")
     */
    public function setWeb(ProviderInterface $web)
    {
        $this->web = $web;
    }
}

class AuraWebModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $app;

    protected function setUp()
    {
        $this->app = Injector::create([new AuraWebModule])->getInstance(__NAMESPACE__ . '\Application');
    }

    public function testGetInstance()
    {
        $context = $this->app->web->get();
        $this->assertInstanceOf('Aura\Web\Context', $context);
    }
}
