<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Application root directory path setter
 */
trait AppDirInject
{
    /**
     * @var string
     */
    private $appDir;

    /**
     * @param string $appDir
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("app_dir")
     */
    public function setAppDir($appDir)
    {
        $this->appDir = $appDir;
    }
}
