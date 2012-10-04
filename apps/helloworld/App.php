<?php
/**
 * Helloworld
 *
 * @package App.Helloworld
 */
namespace Helloworld;

use BEAR\Sunday\Framework\Framework;
use BEAR\Sunday\Application\AppContext;
use BEAR\Sunday\Module\FrameworkModule;
use BEAR\Sunday\Application\AbstractApp;
use Ray\Di\Injector;
use Ray\Di\Di\Inject;

/**
 * Applicaton
 *
 * @package Helloworld
 */
final class App extends AbstractApp
{
    /** Path @var string */
    const DIR = __DIR__;

    /** Run mode Production */
    const RUN_MODE_PROD = 0;

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
        $modules = [new Module\AppModule];
        $injector = Injector::create($modules, $useCache);
        $app = $injector->getInstance(__CLASS__);
        $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');

        return $app;
    }
}
