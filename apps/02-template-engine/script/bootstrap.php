<?php
/**
 * App boot
 *
 * Required to set: $appName, $appPath
 *
 * @packate BEAR.template
 *
 */
namespace template;

$appName = __NAMESPACE__;
$system = dirname(dirname(dirname(__DIR__)));
$appPath  = dirname(__DIR__);

include __DIR__ . '/loader.php';
include $system . '/packages/BEAR.Framework/script/bootstrap.php';

// Haanga static init
\Haanga::configure([
            'template_dir' => '/',
            'cache_dir' => dirname(__DIR__) . '/tmp/haanga',
]);
return [$di, $resource, $page, $method];