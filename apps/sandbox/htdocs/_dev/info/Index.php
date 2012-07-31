<?php
require __DIR__ . '/header.php';
$mode = isset($_GET['mode']) ? $_GET['mode'] : '404';
$file =  __DIR__ . "/{$mode}/{$mode}.php";
$page = file_exists($file) ?  $file : __DIR__ . '/body/404.php';
echo require $page;
require __DIR__ . '/footer.php';