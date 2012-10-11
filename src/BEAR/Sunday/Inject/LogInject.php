<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Guzzle\Common\Log\LogAdapterInterface;
use Ray\Di\Di\Inject;

/**
 * Inject logger
 *
 * @package    BEAR.Sunday
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
     * Logger setter
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
