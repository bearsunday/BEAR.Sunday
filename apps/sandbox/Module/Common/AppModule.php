<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace Sandbox\Module\Common;

use BEAR\Framework\Module;
use BEAR\Framework\Interceptor\TimeStamper;
use BEAR\Framework\Interceptor\Transactional;
use Sandbox\Interceptor\PostFormValidater;
use Sandbox\Interceptor\TimeMessage;
use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;

/**
 * Application module
 *
 * @package    Sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure()
    {
        // di - application
        $this->bind()->annotatedWith('greeting_msg')->toInstance('Hola');
        $this->bind('BEAR\Resource\Renderable')->annotatedWith('hal')->to('BEAR\Framework\Resource\View\HalRenderer');
        // di - system
        $this->install(new Module\SchemeModule( __NAMESPACE__ . '\SchemeCollectionProvider'));
        $this->install(new Module\WebContext\AuraWebModule);
        $this->install(new Module\TemplateEngine\SmartyModule\SmartyModule);
        $this->install(new Module\Cqrs\CacheModule($this));
        $this->install(new Module\Database\DoctrineDbalModule($this));
        // aop
        $this->installTimeStamper();
        $this->installTransaction();
        $this->installTimeMessage();
        $this->installWritableChecker();
        $this->installNewpostFormValidater();
    }

    /**
     * Check writable directory
     */
    private function installWritableChecker()
    {
        // bind tmp writable checker
        $checker = $this->requestInjection('\Sandbox\Interceptor\Checker');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Sandbox\Resource\Page\Index'),
            $this->matcher->startWith('onGet'),
            [$checker]
        );
    }

    /**
     * @Form - bind form validater
     */
    private function installNewpostFormValidater()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Sandbox\Resource\Page\Blog\Posts\Newpost'),
            $this->matcher->annotatedWith('Sandbox\Annotation\Form'),
            [new PostFormValidater]
        );
    }

    /**
     * @Time - put time to 'time' property
     */
    private function installTimeStamper()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Time'),
            [new TimeStamper]
        );
    }

    /**
     * @Transactional - db transaction
     */
    private function installTransaction()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Transactional'),
            [new Transactional]
        );
    }

    /**
     * Add time message aspect
     */
    private function installTimeMessage()
    {
        // time message binding
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Sandbox\Resource\App\First\Greeting\Aop'),
            $this->matcher->any(),
            [new TimeMessage]
        );
    }
}
