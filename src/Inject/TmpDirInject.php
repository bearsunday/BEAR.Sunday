<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Inject application temporary directory path
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
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("tmp_dir")
     */
    public function setTmpDir($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }
}
