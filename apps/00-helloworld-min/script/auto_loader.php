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
$loader->add('helloWorld', $appPath);
$loader->add('BEAR\Framework\\', $system . '/packages/BEAR.Framework/src');
$loader->add('BEAR\Resource\\', $system . '/vendor/BEAR.Resource/src');
$loader->add('Ray\Di\\', $system . '/vendor/Ray.Di/src');
$loader->add('Ray\Aop\\', $system . '/vendor/Ray.Aop/src');
$loader->register();
