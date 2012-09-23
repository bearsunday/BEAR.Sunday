<?php
/**
 * Application config
 */
$appDir = dirname(__DIR__);

// @Named($key) => instance
$config = [
    // constants
    'app_name' => 'helloworld',
    'app_dir' => $appDir,
    'tmp_dir' => $appDir . '/tmp',
    'log_dir' => $appDir . '/log'
];

return $config;
