<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

use BEAR\Framework\Framework;
use BEAR\Framework\Web\HttpFoundation as Output;

// library manual loading
require_once dirname(dirname(dirname(__DIR__))) . '/vendor/smarty/smarty/libs/Smarty.class.php';

// framework configuration
require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
$framework = (new Framework)->setLoader(__NAMESPACE__, dirname(__DIR__))->setExceptionHandler();

// application instance
new Module\AppModule;

$app = new App([new Module\AppModule], $framework);
return $app;