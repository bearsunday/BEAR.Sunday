<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Guzzle\Common\Log\LogAdapterInterface as Log;

/**
 * Inject logger
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait LogInject
{
    /**
     * Logger
     *
     * @var Log
     */
    private $log;

    /**
     * Logger stter
     *
     * @param Log $log
     *
     * @return void
     * @Inject
     */
    public function setLog(Log $log)
    {
        $this->log = $log;
    }
}
