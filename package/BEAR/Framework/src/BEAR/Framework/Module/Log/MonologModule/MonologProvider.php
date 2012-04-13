<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Log\MonologModule;

use Ray\Di\ProviderInterface as Provide;
use Guzzle\Common\Log\MonologLogAdapter;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Monolog\Handler\StreamHandler;

/**
 * Cache
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class MonologProvider implements Provide
{
    private $logDir;

    /**
     *
     * @param string $logDir
     * @Inject
     * @Named("log_dir")
     */
    public function __construct($logDir)
    {
        $this->logDir = $logDir;
    }

    /**
     * @return CacheAdapter
     */
    public function get()
    {
        $log = new Logger('app');
        $handler = new TestHandler();
//         $log->pushHandler($handler);
        $logFile = $this->logDir . '/app.log';
        $log->pushHandler(new StreamHandler($this->logDir . '/app.log'));
        $adapter = new MonologLogAdapter($log);
        return $adapter;
    }
}
