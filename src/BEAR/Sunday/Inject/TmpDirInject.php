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
 * Inject tmp_dir
 *
 * @package BEAR.Sunday
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
