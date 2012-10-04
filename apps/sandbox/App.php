<?php
/**
 * sandbox
 *
 * @package sandbox
 */
namespace sandbox;

use BEAR\Framework\Framework\Framework;
use BEAR\Framework\Application\AppContext;
use BEAR\Framework\Application\AbstractApp;
use BEAR\Framework\Inject\AppDependencyInject;
use Ray\Di\Injector;
use LogicException;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Applicaton
 *
 * @package sandbox
 */
final class App extends AbstractApp
{
    /** run mode @var string*/
    const RUN_MODE_PROD = 'Prod';
    const RUN_MODE_API  = 'Api';
    const RUN_MODE_DEV  = 'Dev';
    const RUN_MODE_STAB = 'Stab';
    const RUN_MODE_TEST = 'Test';

    /** application dir path @var string */
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
        include_once Framework::$systemRoot . '/vendor/smarty/smarty/distribution/libs/Smarty.class.php';

        // cached application ?
        $cacheKey = 'App-' . __NAMESPACE__ . PHP_SAPI . $runMode;
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);
        } else {
            // run mode module
            $modeModule = __NAMESPACE__ . '\Module\\' . $runMode . 'Module';
            try {
                $modules = [new $modeModule];
            } catch (Exception $e) {
                throw new LogicException('Run mode module not loaded', $runMode);
            }

            // return application object
            $injector = Injector::create($modules, $useCache);
            $app = $injector->getInstance(__CLASS__);
            $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');

            // log binding info
            file_put_contents(__DIR__ . "/log/di-log-{$cacheKey}.log", (string) $injector);
        }

        return $app;
    }
}
