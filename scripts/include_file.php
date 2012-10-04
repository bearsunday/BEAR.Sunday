<?php
// reroute another PHP file
ca
preg_match('/\/_dev(.+)$/', $_SERVER['REQUEST_SCRIPT'], $matches);
if (! $matches) {
    return;
}
$scrpitFile = __DIR__  . $matches[0];
echo $scrpitFile;exit;

if (PHP_SAPI !== 'cli' && file_exists($scrpitFile)) {
    include $scrpitFile;

    exit(0);
}