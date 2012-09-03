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

    /** Run mode API */
    const RUN_MODE_API = 'Api';
    const RUN_MODE_HAL = 'Hal';

    /** Run mode Develop */
    const RUN_MODE_DEV = 'Dev';

    /** Run mode Stab */
    const RUN_MODE_STAB = 'Stab';

    /** Run mode unit test */
    const RUN_MODE_TEST = 'Test';

    /**
     * Dir
     *
     * @var string
     */
    const DIR = __DIR__;

    /**
     * Return application instance
     *
     * @param integer $runMode
     */
    public static function factory($runMode, $useCache = false)
    {
        // class loader
        (new Framework)->setLoader(__NAMESPACE__, __DIR__);

        // cached application ?
        $cacheKey = '[App] ' . __NAMESPACE__ . '-' . PHP_SAPI . '-' . $runMode;
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);
        } else {
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
        }

        // register logging
        $app->logger->register($app);
        return $app;
    }
}
