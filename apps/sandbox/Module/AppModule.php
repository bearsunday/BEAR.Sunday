<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module;

use BEAR\Framework\Module\Schema;
use BEAR\Framework\Module\Database;
use BEAR\Framework\Module\Cqrs;
use BEAR\Framework\Module\WebContext;
use BEAR\Framework\Module\TemplateEngine;

use Ray\Di\AbstractModule;

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
        $this->install(new Cqrs\CacheModule);
        $this->install(new WebContext\AuraWebModule);
        $this->install(new TemplateEngine\SmartyModule);
        $this->installWritableChecker();
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
}