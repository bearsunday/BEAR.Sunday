<?php
/**
 * Hello World - Min
 *
 * no router
 * no view
 * no app resource
 */

// profiler
require dirname(dirname(dirname(__DIR__))) . '/scripts/profile.php';

$app = require dirname(__DIR__) . '/scripts/instance.php';
$response = $app->resource->get->uri('page://self/minhello')->eager->request();

echo $response->body;
exit(0);
