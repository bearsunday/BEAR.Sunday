<?php
/**
 * Return db connection
 *
 * @var PDO
 *
 * @global $_ENV['BEAR_DB_ID']
 * @global $_ENV['BEAR_DB_PASSOWRD']
 */
$id = isset($_ENV['BEAR_DB_ID']) ? $_ENV['BEAR_DB_ID'] : 'root';
$password = isset($_ENV['BEAR_DB_PASSWORD']) ? $_ENV['BEAR_DB_PASSWORD'] : '';
return new \PDO("mysql:host=localhost; dbname=blogbeartest", $id, $password);
