<?php
/**
 * Return validated path info
 *
 * @return array [$fullPath, $line, $relativePath]
 */

// input
$line = isset($_GET['line']) ? $_GET['line'] : 0;
$path = isset($_REQUEST['file']) ?  $_REQUEST['file'] : false;
$rootDir = isset($_ENV['SUNDAY_ROOT']) ? $_ENV['SUNDAY_ROOT'] : dirname(dirname(dirname(dirname(dirname(__DIR__)))));
if (file_exists($path)) {
    $fullPath = $path;
    $relativePath = str_replace($rootDir, '', $fullPath);
} else {
    $fullPath = $rootDir . '/' . $path;
    $relativePath = $path;
}
// validate
if (!is_readable($fullPath)) {
    throw new \InvalidArgumentException("Not found. {$fullPath} is not readable.");
}
if (strpos($fullPath, $rootDir) === false) {
    throw new \OutOfRangeException($fullPath);
}
return array($fullPath, $line, $relativePath);
