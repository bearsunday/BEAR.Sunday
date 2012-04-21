<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Log\MonologModule;

use Guzzle\Common\Log\MonologLogAdapter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use RuntimeException;

/**
 * Cache
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class MonologProvider implements Provide
{
    /**
     * Log directory path
     * 
     * @var string
     */
    private $logDir;

    /**
     * Constructor
     *
     * @param string $logDir
     * 
     * @Inject
     * @Named("log_dir")
     */
    public function __construct($logDir)
    {
        $this->logDir = $logDir;
    }

    /**
     * Provide instance
     * 
     * @return CacheAdapter
     */
    public function get()
    {
        $log = new Logger('app');
        $logFile = $this->logDir . '/'. PHP_SAPI . '.app.log';
        touch($logFile);
        if (is_writable($logFile)) {
        	$log->pushHandler(new StreamHandler($logFile));
        } else {
        	$log->pushHandler(new TestHandler);
        }
        $adapter = new MonologLogAdapter($log);
        return $adapter;
    }
}
