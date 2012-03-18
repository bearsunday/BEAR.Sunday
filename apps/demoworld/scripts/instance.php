<?php
/**
 * demoworld
 *
 * @package App.demoworld
 */
namespace demoworld;

use BEAR\Framework\Framework;

require dirname(dirname(dirname(__DIR__))) . '/vendor/smarty/smarty/libs/Smarty.class.php';

// framework configuration
require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
$namespaces = [
    'helloworld' => dirname(dirname(__DIR__))
];
$framework = (new Framework)->setLoader(__NAMESPACE__, dirname(__DIR__), $namespaces)->setExceptionHandler();

// application instance
$app = new App([new Module\AppModule], $framework);
return $app;