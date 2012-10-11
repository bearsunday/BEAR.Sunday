<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;


/**
 * Inject app dir
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait AppDirInject
{
    /**
     * App directory path
     *
     * @var string
     */
    private $appDir;

    /**
     * App directory path setter
     *
     * @param string $appDir
     *
     * @return void
     *
     * @Inject
     * @Named("app_dir")
     */
    public function setAppDir($appDir)
    {
        $this->appDir = $appDir;
    }
}
