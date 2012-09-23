<?php
/**
 * Application config
 */
$id = isset($_ENV['BEAR_DB_ID']) ? $_ENV['BEAR_DB_ID'] : 'root';
$password = isset($_ENV['BEAR_DB_PASSWORD']) ? $_ENV['BEAR_DB_PASSWORD'] : '';
$appDir = dirname(__DIR__);

// @Named($key) => instance
$config = [
    // database
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbear',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbear',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ],
    // constants
    'app_name' => 'sandbox',
    'app_dir' => $appDir,
    'tmp_dir' => $appDir . '/tmp',
    'log_dir' => $appDir . '/log'
];

return $config;
