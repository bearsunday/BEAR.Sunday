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
use BEAR\Framework\Module\Provider\CacheProvider;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Doctrine\Common\Cache\ApcCache as Cache;

use helloworld\Module\AppModule as HelloWorldModule;
use Ray\Di\Scope;
use Ray\Di\AbstractModule;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class ProdModule extends AbstractModule
{
    const RESOURCE_CACHE_INTERFACE = 'Guzzle\Common\Cache\CacheAdapterInterface';
    const RESOURCE_CACHE_PROVIDER  = 'BEAR\Framework\Module\Provider\CacheProvider';

    /**
     * App name
     *
     * @var string
     */
    private $app;

    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // install framework module
        $tmpDir = dirname(__DIR__) . '/tmp';
        $logDir = dirname(__DIR__) . '/log';
        $this->install(new FrameworkModule($this->app, $tmpDir, $logDir));

        // mode specific install
        $masterDb = $slaveDb = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'blogbear',
            'user' => 'root',
            'password' => null,
            'charset' => 'UTF8'
        ];
        $this->install(new Database\DoctrineDbalModule($masterDb, $slaveDb));

        $this->bind(self::RESOURCE_CACHE_INTERFACE)
        ->annotatedWith('resource_cache')
        ->toInstance(new CacheAdapter(new Cache));


        // install common app module
        $this->install(new AppModule($this));
    }
}