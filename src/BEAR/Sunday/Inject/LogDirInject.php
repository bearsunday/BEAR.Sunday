<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject log dir
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
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
     * @Inject
     * @Named("log_dir")
     */
    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
    }
}
