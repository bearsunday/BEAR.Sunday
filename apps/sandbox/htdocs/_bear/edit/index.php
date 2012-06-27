<?php
/**
 * Display editor
 *
 * @package BEAR.CodeEdit
 */
list($fullPath, $line, $relativePath) = require __DIR__ . '/input.php';

// set variable for view
$view = array();
$view['file_path'] = $relativePath;
$view['line'] = $line;
$view['file_contents'] = file_get_contents($fullPath);
$id = md5($fullPath);
$view['mod_date'] = date (DATE_RFC822, filemtime($fullPath));
$view['owner_info'] = function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($fullPath)) : array('name' => 'n/a');
$fileperms = substr(decoct(fileperms($fullPath)), 2);;
$view['is_writable'] = is_writable($fullPath);
$view['is_writable_label'] = $view['is_writable'] ? "" : " Read Only";
$view['auth']  = md5(session_id() . $id);

// render
include 'view.php';
