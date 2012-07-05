<?php 
/**
 * Application config
 */
return [
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbear',
        'user' => 'root',
        'password' => null,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'blogbear',
        'user' => 'root',
        'password' => null,
        'charset' => 'UTF8'
    ]
];