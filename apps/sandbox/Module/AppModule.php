<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use sandbox\Interceptor\FormValidater;

use BEAR\Framework\Module;
use BEAR\Framework\Module\Schema;
use BEAR\Framework\Module\Database;
use BEAR\Framework\Module\Cqrs;
use BEAR\Framework\Module\WebContext;
use BEAR\Framework\Module\TemplateEngine;
use BEAR\Framework\Interceptor\TimeStamper;
use Ray\Di\AbstractModule;

// cache adapter
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\Apc as CacheBackEnd;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->install(new Schema\StandardSchemaModule(__NAMESPACE__));
        $this->install(new Cqrs\CacheModule(new CacheAdapter(new CacheBackEnd)));
        $this->install(new WebContext\AuraWebModule);
        $this->install(new TemplateEngine\SmartyModule);
        $this->installWritableChecker();
        $this->installFormValidater();
        $this->installTimeStamper();
    }

    /**
     * installWritableChecker
     */
    private function installWritableChecker()
    {
        // bind tmp writable checker
        $checker = $this->requestInjection('\sandbox\Interceptor\Checker');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\Page\Index'),
            $this->matcher->any(),
            [$checker]
        );
    }
    
    private function installFormValidater()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\Page\Blog\Posts\Newpost'),
       	    $this->matcher->annotatedWith('sandbox\Annotation\Form'),
            [new FormValidater]
        );
    }
    
    private function installTimeStamper()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
       	    $this->matcher->annotatedWith('BEAR\Framework\Annotation\Time'),
            [new TimeStamper]
        );
    }
}