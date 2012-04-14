<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

/**
 * Inject tmp_dir
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
