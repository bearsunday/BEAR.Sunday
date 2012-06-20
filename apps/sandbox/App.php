<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\AbstractAppContext;
use Ray\Di\Injector;

require_once dirname(dirname(__DIR__)) . '/vendor/smarty/smarty/libs/Smarty.class.php';
require_once dirname(dirname(__DIR__)) . '/vendor/vdump/vdump/vdump/src.php';

/**
 * Applicaton
 *
 * @package sandbox
 */
final class App extends AbstractAppContext
{
    /** Version @var string */
    const VERSION = '0.2.0';

    /** Name @var string */
    const NAME = __NAMESPACE__;

    /** Path @var string */
    const DIR = __DIR__;

    /** Run mode Production */
    const RUN_MODE_PROD = 'prod';

    /** Run mode Production */
    const RUN_MODE_API = 'api';

    /** Run mode Develop */
    const RUN_MODE_DEV = 'dev';

    /** Run mode Stab */
    const RUN_MODE_STAB = 'stab';

    /** Run mode unit test */
    const RUN_MODE_TEST = 'test';

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
            case self::RUN_MODE_DEV:
                $modules = [new Module\DevModule(__NAMESPACE__)];
                break;
            case self::RUN_MODE_API:
                $modules = [new Module\ApiModule(__NAMESPACE__)];
                break;
            case self::RUN_MODE_STAB:
                $modules = [new Module\StabModule(__NAMESPACE__)];
                break;
            case self::RUN_MODE_TEST:
                $modules = [new Module\TestModule(__NAMESPACE__)];
                break;
            case self::RUN_MODE_PROD:
            default:
                $modules = [new Module\ProdModule(__NAMESPACE__)];
        }
        $injector = Injector::create($modules, $useCache);
        $app = $injector->getInstance(__CLASS__);
        $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');
        return $app;
    }
}