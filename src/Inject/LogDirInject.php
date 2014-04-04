<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Inject application log dir
 */
trait LogDirInject
{
    /**
     * Tmp dir
     *
     * @var string
     */
    private $logDir;

    /**
     * Set tmp dir path
     *
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
