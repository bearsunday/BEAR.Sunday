<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\Module\StandardModule;
use BEAR\Framework\Module\TemplateEngine\SmartyModule;
use BEAR\Framework\Module\Database;
use helloworld\Module\AppModule;
use Ray\Di\Scope;
use Ray\Di\AbstractModule;


/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class DevModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // application config
        $masterDb = $slaveDb = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'blogbear',
            'user' => 'root',
            'password' => null,
            'charset' => 'UTF8'
        ];
        $tmpDir = dirname(__DIR__) . '/tmp';
        $this->install(new Database\DoctrineDbalModule($masterDb, $slaveDb));

        // install enviroment-depend module
//         $this->installWritableChecker();
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
