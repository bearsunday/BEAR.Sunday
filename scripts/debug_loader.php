<?php
require_once dirname(__DIR__) . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_lib.php';
require_once dirname(__DIR__) . '/vendor/facebook/xhprof/xhprof_lib/utils/xhprof_runs.php';

// reroute another PHP file
preg_match('/\/_dev(.+)$/', $_SERVER['SCRIPT_FILENAME'], $matches);
if (! $matches) {
    return false;
}
