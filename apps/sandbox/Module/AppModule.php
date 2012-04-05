<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module\TemplateEngine\SmartyModule;

use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use BEAR\Framework\Module;
use BEAR\Framework\Module\Extension;
use BEAR\Framework\Interceptor\DbInjector;
use BEAR\Framework\Interceptor\ViewAdapter;
use BEAR\Framework\Interceptor\ViewAdapter\SmartyBackend;
use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
use Ray\Di\Annotation;
use Ray\Di\Config;
use Ray\Di\Forge;
use Ray\Di\Container;
use Ray\Di\Injector as Di;
use Ray\Di\Definition;
use Ray\Di\Injector;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;
use Smarty;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    private $mode = '';

    public function __construct($mode = 0)
    {
        $this->mode = $mode;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        switch ($this->mode) {
            default:
            case 'dev':
                $this
                ->bind()
                ->annotatedWith('master_db')
                ->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);

                $this
                ->bind()
                ->annotatedWith('slave_db')
                ->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);
                ;
                break;

        }
        $this->installCommon();
    }

    private function installCommon()
    {
        $this->install(new Module\Database\DoctrineDbalModule);
        $this->install(new Module\Schema\StandardSchemaModule);
        $this->install(new Module\Cqrs\CacheModule);
        $this->install(new Module\WebContext\AuraWebModule);
        $this->install(new Module\TemplateEngine\SmartyModule);
    }
}