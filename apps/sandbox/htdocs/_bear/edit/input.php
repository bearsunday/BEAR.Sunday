<?php
/**
 * Return validated path info
 * 
 * @return array [$fullPath, $line, $relativePath]
 */

// input
$relativePath = isset($_REQUEST['file']) ?  $_REQUEST['file'] : false;
$line = isset($_GET['line']) ? $_GET['line'] : 0;
$rootDir = isset($_ENV['SUNDAY_ROOT']) ? $_ENV['SUNDAY_ROOT'] : dirname(dirname(dirname(dirname(dirname(__DIR__)))));
$fullPath = $rootDir . '/' . $relativePath;
// validate
if (!is_readable($fullPath)) {
	throw new \InvalidArgumentException("Not found. {$fullPath} is not readable.");
}
if (strpos($fullPath, $rootDir) === false) {
	throw new \OutOfRangeException($fullPath);
}
return array($fullPath, $line, $relativePath);