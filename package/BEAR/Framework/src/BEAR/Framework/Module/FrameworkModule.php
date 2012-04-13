<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\AbstractModule;
use BEAR\Framework\Module\Log;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class FrameworkModule extends AbstractModule
{
    /**
     * App root path
     *
     * @var string
     */
    private $appDir;

    /**
     *
     * @param string $appDir
     */
    public function __construct($app)
    {
        $this->appDir = $app::DIR;
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        // bind
        $tmpDir = $this->appDir . '/tmp';
        $logDir = $this->appDir . '/log';
        $this->bind()->annotatedWith("tmp_dir")->toInstance($tmpDir);
        $this->bind()->annotatedWith("log_dir")->toInstance($logDir);

        // install log module
        $this->install(new Log\MonologModule);
    }
}