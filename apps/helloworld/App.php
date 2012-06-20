<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace helloworld;

use BEAR\Framework\Framework;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\AbstractAppContext;
use Ray\Di\Injector;

require_once dirname(dirname(__DIR__)) . '/vendor/smarty/smarty/libs/Smarty.class.php';

/**
 * Applicaton
 *
 * @package sandbox
 */
final class App extends AbstractAppContext
{
    /** Version @var string */
    const VERSION = '0.1.0';

    /** Name @var string */
    const NAME = __NAMESPACE__;

    /** Path @var string */
    const DIR = __DIR__;

    /** Run mode Production */
    const RUN_MODE_PROD = 0;

    /** Run mode Develop */
    const RUN_MODE_DEV = 1;

    /** Run mode Stab */
    const RUN_MODE_STAB = 10;

    /**
     * Return application instance
     *
     * @param integer $runMode
     */
    public static function factory($runMode = self::RUN_MODE_PROD, $useCache = false)
    {
        // configure framework
        (new Framework)->setLoader(__NAMESPACE__, __DIR__);

        // configure application
        $cacheKey = 'app' . __NAMESPACE__ . PHP_SAPI . $runMode;
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);
            return $app;
        }
        // run mode
        switch ($runMode) {
            case self::RUN_MODE_PROD:
            default:
                $modules = [new FrameworkModule(__NAMESPACE__, __DIR__ . '/tmp', __DIR__ . '/log'), new Module\AppModule];
        }
        $injector = Injector::create($modules, $useCache);
        $app = $injector->getInstance(__CLASS__);
        $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');
        return $app;
    }
}