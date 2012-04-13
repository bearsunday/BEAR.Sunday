<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use helloworld\Module\AppModule;

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
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;
use Zend\Cache\Backend\File as CacheBackEnd;
use Smarty;
use ReflectionClass;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class NamedModule extends AbstractModule
{
    /**
     *
     * @param array $names
     */
    public function __construct(array $names)
    {
        $this->names = $names;
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        foreach ($names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}