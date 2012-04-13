<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

/**
 * Inject application namespace
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
     * @param string $tmp
     *
     * @Inject
     * @Named("app_name")
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }
}
