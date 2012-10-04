<?php
/**
 * Save contents
 *
 * @package BEAR.CodeEdit
 */

list($fullPath, $line, $relativePath) = require __DIR__ . '/input.php';
$contents = $_POST['contents'];
$result = (string) file_put_contents($fullPath, $contents, LOCK_EX | FILE_TEXT);
$log = "codeEdit saved:$fullPath addr:{$_SERVER["REMOTE_ADDR"]} result:{$result}";
error_log($log);
echo $log;
