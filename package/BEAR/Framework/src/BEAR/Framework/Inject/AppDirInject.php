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
 * Inject logger
 *
 * @package    BEAR.Framework
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
     * App directory path stter
     *
     * @param string $viewPath
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
