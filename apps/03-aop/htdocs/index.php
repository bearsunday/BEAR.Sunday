<?php

/*
 * bootstrap provides as follows.
 *
 * Resource       $reource Resource clinet
 * String         $method  Page request method
 * ResourceObject $page    Page resource
 */
include dirname(__DIR__) . '/script/bootstrap.php';

try {
    $http = $resource->$method->object($page)->linkSelf('view')->eager->request();
} catch (\Exception $e) {
    echo $e . PHP_EOL;
    exit(1);
}

// http/console output
include dirname(__DIR__) . '/script/output.php';