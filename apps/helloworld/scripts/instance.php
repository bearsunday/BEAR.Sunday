<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace helloworld;

use BEAR\Framework\Framework;

require_once dirname(dirname(dirname(__DIR__))) . '/vendor/smarty/smarty/libs/Smarty.class.php';

// framework configuration
require_once dirname(dirname(dirname(__DIR__))) . '/package/BEAR/Framework/src/BEAR/Framework/Framework.php';
$framework = (new Framework)->setLoader(__NAMESPACE__, dirname(__DIR__));

// application instance
$app = new App([new Module\AppModule], $framework);
return $app;