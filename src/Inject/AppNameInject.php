<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Application namespace setter
 */
trait AppNameInject
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @param string $appName
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("app_name")
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }
}
