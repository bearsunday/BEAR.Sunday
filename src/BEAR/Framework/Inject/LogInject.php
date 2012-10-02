<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;
use Guzzle\Common\Log\LogAdapterInterface;

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
     * @param LogAdapterInterface $log
     *
     * @return void
     * @Inject
     */
    public function setLog(LogAdapterInterface $log)
    {
        $this->log = $log;
    }
}
