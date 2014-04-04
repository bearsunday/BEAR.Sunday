<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Guzzle\Log\LogAdapterInterface;

/**
 * Inject logger
 */
trait LogInject
{
    /**
     * Logger
     *
     * @var LogAdapterInterface
     */
    private $log;

    /**
     * Logger setter
     *
     * @param LogAdapterInterface $log
     *
     * @return void
     * @Ray\Di\Di\Inject
     */
    public function setLog(LogAdapterInterface $log)
    {
        $this->log = $log;
    }
}
