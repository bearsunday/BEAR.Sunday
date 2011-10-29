<?php

namespace Aura\Framework;
use Aura\Autoload\Loader;
use Aura\Di\Manager;
use Aura\Di\Forge;
use Aura\Di\Config;

namespace BEAR\Di;
use BEAR\Framework\FrameworkModule,
BEAR\App\HelloWorld\Modules\AppModule;

/**
 * Setup.
 */
// turn up error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);
ini_set('html_errors', false);

// BEAR system directory
$system = dirname(dirname(dirname(__DIR__)));

// force the include path
set_include_path("$system/include");

/**
 * Autoloader
 */
require "$system/package/Aura.Autoload/src.php";
$loader = new Loader;
$loader->register();

/**
 * DI container
 */
$loader->addPrefix('Ray\Di\\', "$system/package/Ray.Di/src");
$di = new Injector(new Container(new Forge(new Config(new Annotation)), new AppModule(new FrameworkModule)));

// init
$dispatcher = $di->getInstance('BEAR\Dispatcher');
$page = $dispatcher