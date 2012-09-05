<?php
/**
 * Config for unit test
 */
$id = isset($_ENV['BEAR_DB_ID']) ? $_ENV['BEAR_DB_ID'] : 'root';
$password = isset($_ENV['BEAR_DB_PASSWORD']) ? $_ENV['BEAR_DB_PASSWORD'] : '';
return [
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbeartest',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbeartest',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ]
];
