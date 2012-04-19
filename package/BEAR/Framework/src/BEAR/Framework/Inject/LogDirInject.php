<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject tmp_dir
 *
 * @package    BEAR.Framework
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
     * @Named("tmp_dir")
     */
    public function setlogDir($logDir)
    {
        $this->logDir = $logDir;
    }
}
