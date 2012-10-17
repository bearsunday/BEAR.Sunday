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
 * Inject application namespace
 *
 * @package    BEAR.Sunday
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
