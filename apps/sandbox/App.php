<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\AppContext;
use BEAR\Framework\Inject\AppDependencyInject;
use Ray\Di\Injector;
use LogicException;

require_once dirname(dirname(__DIR__)) . '/vendor/smarty/smarty/distribution/libs/Smarty.class.php';
require_once dirname(dirname(__DIR__)) . '/vendor/vdump/vdump/vdump/src.php';

/**
 * Applicaton
 *
 * @package sandbox
 */
final class App implements AppContext
{
    use AppDependencyInject;

    /** Version @var string */
    const VERSION = '0.2.0';

    /** Run mode Production */
    const RUN_MODE_PROD = 'Prod';

    /** Run mode Production */
    const RUN_MODE_API = 'Api';

    /** Run mode Develop */
    const RUN_MODE_DEV = 'Dev';

    /** Run mode Stab */
    const RUN_MODE_STAB = 'Stab';

    /** Run mode unit test */
    const RUN_MODE_TEST = 'Test';

    /**
     * Return application instance
     *
     * @param integer $runMode
     */
    public static function factory($runMode, $useCache = false)
    {
        // configure framework
        (new Framework)->setLoader(__NAMESPACE__, __DIR__);

        // cached application ?
        $cacheKey = 'app' . __NAMESPACE__ . PHP_SAPI . $runMode;
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);

            return $app;
        }

        // run mode module
        $modeModule = __NAMESPACE__ . '\Module\\' . $runMode . 'Module';
        try {
            $modules = [new $modeModule(__NAMESPACE__)];
        } catch (Exception $e) {
            throw new LogicException('Run mode module not loaded', $runMode);
        }

        // return application object
        $injector = Injector::create($modules, $useCache);
        $app = $injector->getInstance(__CLASS__);
        $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');

        return $app;
    }
}
