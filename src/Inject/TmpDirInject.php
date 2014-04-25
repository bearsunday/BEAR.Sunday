<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Temporary directory path setter
 */
trait TmpDirInject
{
    /**
     * @var string
     */
    private $tmpDir;

    /**
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
