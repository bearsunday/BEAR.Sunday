<?php

/**
 * Auto Loader using Aura.Autoload.
 *
 * @package    hellowolrd
 * @subpackage script
 */
$appPath = dirname((__DIR__));
$system = dirname(dirname($appPath));

$loader = require  $system . '/vendor/Aura.Autoload/scripts/instance.php';
$loader->addPrefix('helloWorld', $appPath);
$loader->addPrefix('BEAR\Framework\\', $system . '/packages/BEAR.Framework/src');
$loader->addPrefix('BEAR\Resource\\', $system . '/vendor/BEAR.Resource/src');
$loader->addPrefix('Ray\Di\\', $system . '/vendor/Ray.Di/src');
$loader->addPrefix('Ray\Aop\\', $system . '/vendor/Ray.Aop/src');
$loader->register();