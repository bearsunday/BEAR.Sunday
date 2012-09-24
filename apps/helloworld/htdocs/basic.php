<?php
/**
 * Hello World - basic
 *
 * no router
 * no view
 * no app resource
 */

// profiler
//require dirname(dirname(dirname(__DIR__))) . '/scripts/profile.php';

$app = require dirname(__DIR__) . '/scripts/instance.php';
$response = $app->resource->get->uri('page://self/hello')->withQuery(['name' => 'World !'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
exit(0);
