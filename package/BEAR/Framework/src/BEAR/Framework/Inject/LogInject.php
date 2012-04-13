<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Guzzle\Common\Log\LogAdapterInterface as Log;

/**
 * Inject logger
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
     * Set logger
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
