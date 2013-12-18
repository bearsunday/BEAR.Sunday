<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Scope;
use BEAR\Resource\Module\ResourceModule as BearResourceModule;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


/**
 * Resource module
 */
class ResourceModule extends AbstractModule
{
    protected $appName;

    /**
     * @param string $appName {Vendor}\{NameSpace}
     *
     * @Inject
     * @Named("app_name")
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\LoggerInterface')->toProvider(__NAMESPACE__ . '\ResourceLoggerProvider')->in(Scope::SINGLETON);
        $this->install(new BearResourceModule($this->appName));
    }
}
