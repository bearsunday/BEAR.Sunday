<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject tmp_dir
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait TmpDirInject
{
    /**
     * Tmp dir
     *
     * @var string
     */
    private $tmpDir;

    /**
     * Set tmp dir path
     *
     * @param string $tmpDir
     *
     * @Inject
     * @Named("tmp_dir")
     */
    public function setTmpDir($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }
}
