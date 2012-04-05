<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\AbstractAppContext;


/**
 * Applicaton
 *
 * @package sandbox
 */
final class App extends AbstractAppContext
{     /** Version @var string */
    const VERSION = '0.1.0';

    /** Name @var string */
    const NAME = __NAMESPACE__;

    /** Path @var string */
    const DIR = __DIR__;

    /**
     * Return application instance
     *
     * @param integer $mode
     */
    public static function getInstance($namespace, $mode = 0)
    {
        // configure framework
        $framework = (new Framework)->setLoader(__NAMESPACE__, __DIR__)->setExceptionHandler();

        // configure application
        $app = new App([new Module\AppModule($mode)], $framework);
        return $app;
    }
}