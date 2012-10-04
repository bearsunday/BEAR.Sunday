<?php
require_once $system . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_lib.php';
require_once $system . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_runs.php';

// reroute another PHP file
preg_match('/\/_dev(.+)$/', $_SERVER['SCRIPT_FILENAME'], $matches);
if (! $matches) {
    return;
}
$scrpitFile = __DIR__  . $matches[0];
if (PHP_SAPI !== 'cli' && file_exists($scrpitFile)) {
    include $scrpitFile;
    exit(0);
}