<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use sandbox\Interceptor\PostFormValidater;
use sandbox\Interceptor\TimeMessage;

use BEAR\Framework\Module;
use BEAR\Framework\Module\Schema;
use BEAR\Framework\Module\Cqrs;
use BEAR\Framework\Module\WebContext;
use BEAR\Framework\Module\TemplateEngine;
use BEAR\Framework\Interceptor\TimeStamper;
use BEAR\Framework\Interceptor\Transactional;
use BEAR\Framework\Module\Database;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
// cache adapter
// use Guzzle\Common\Cache\Zf2CacheAdapter;
// use Zend\Cache\StorageFactory;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ApcCache as CacheStorage;



/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * Constructor
     * 
     * @param InjectorInterface $injector
     */
    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
        parent::__construct();
    }
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cache = new CacheAdapter(new CacheStorage);
        //         $cacheStorage = StorageFactory::factory(['adapter' => 'apc']);
        //         $cache = new Zf2CacheAdapter($cacheStorage);
        $this->install(new Schema\StandardSchemaModule(__NAMESPACE__));
        $this->install(new Cqrs\CacheModule($cache));
        $this->install(new WebContext\AuraWebModule);
        $this->install(new TemplateEngine\SmartyModule\SmartyModule);
        $this->install(new Module\Database\DoctrineDbalModule($this->injector));
        $this->installWritableChecker();
        $this->installFormValidater();
        $this->installTimeStamper();
        $this->installTransaction();
        
        // greeting 
        $this->bind()->annotatedWith('greeting_msg')->toInstance('Hola');
        // time message binding
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\App\First\Greeting\Aop'),
            $this->matcher->any(),
            [new TimeMessage]
        );
    }

    /**
     * installWritableChecker
     */
    private function installWritableChecker()
    {
        // bind tmp writable checker
        $checker = $this->injector->getInstance('\sandbox\Interceptor\Checker');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\Page\Index'),
            $this->matcher->startWith('__construct'),
            [$checker]
        );
    }

    /**
     * @Form - bind form validater
     */
    private function installFormValidater()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\Page\Blog\Posts\Newpost'),
            $this->matcher->annotatedWith('sandbox\Annotation\Form'),
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
}
