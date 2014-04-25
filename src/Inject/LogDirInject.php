<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Log directory path setter
 */
trait LogDirInject
{
    /**
     * @var string
     */
    private $logDir;

    /**
     * @param string $logDir
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("log_dir")
     */
    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
    }
}
