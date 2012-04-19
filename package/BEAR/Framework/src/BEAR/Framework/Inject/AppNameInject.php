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
 * Inject application namespace
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait AppNameInject
{
    /**
     * application namespace
     *
     * @var string
     */
    private $appName;

    /**
     * App name (=namespace) setter
     *
     * @param string $appName
     *
     * @Inject
     * @Named("app_name")
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }
}
