<?php
/**
 * Include
 *
 * @package    hellowolrd
 * @subpackage script
 *
 * @return  Ray\Di\InjectorInterface
 */

// vendor/* loader
$system = dirname(dirname(__DIR__));
require $system . '/vendor/Ray.Aop/src.php';
require $system . '/vendor/Ray.Di/src.php';
require $system . '/vendor/BEAR.Resource/src.php';
// require $system . '/vendor/Aura.Router/src.php';
// require $system . '/vendor/Aura.Signal/src.php';
require $system . '/package/BEAR.Framework/src.php';


require_once __DIR__ . '/Module/AppModule.php';
require_once __DIR__ . '/Module/SchemeCollectionProvider.php';
require_once __DIR__ . '/Page/Hello.php';
