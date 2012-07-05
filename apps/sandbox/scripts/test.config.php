<?php 
/**
 * Config for unit test
 */
return [
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbeartest',
        'user' => 'root',
        'password' => null,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbeartest',
        'user' => 'root',
        'password' => null,
        'charset' => 'UTF8'
    ]
];