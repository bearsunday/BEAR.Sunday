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
    const RUN_MODE_PROD = 1;

    /** Run mode Develop */
    const RUN_MODE_DEV = 1;

    /**
     * Return application instance
     *
     * @param integer $runMode
     */
    public static function factory($runMode)
    {
        // configure framework
        $framework = (new Framework)->setLoader(__NAMESPACE__, __DIR__)->setExceptionHandler();

        // configure application
        $cacheKey = __NAMESPACE__ . $runMode . filemtime(dirname(__DIR__));
        $useCache = (! $runMode) && extension_loaded('apc');
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);
            return $app;
        }
        // run mode
        switch ($runMode) {
            case self::RUN_MODE_DEV:
                apc_clear_cache();
                apc_clear_cache('user');
                $modeModule = new module\DevModule;
                break;
            case self::RUN_MODE_PROD:
            default:
                $modeModule = new module\ProdModule;
        }
        $injector = Injector::create([new FrameworkModule(__CLASS__), new $modeModule, new module\AppModule]);
        $app = $injector->getInstance(__CLASS__);
        if ($useCache) {
            apc_store($cacheKey, $app);
        }
        return $app;
    }
}