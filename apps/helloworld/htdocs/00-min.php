<?php
/**
 * Minimum Hello World
 *
 * no router
 * no view
 * no app resource
 * no page object graph cache
 */

require dirname(__DIR__) . '/src.php';
// require $appPath . '/script/auto_loader.php';
$di = require dirname(__DIR__) . '/script/di.php';

// resource request
$response = $di->getInstance('\BEAR\Resource\Client')->get->uri('page://self/hello')->withQuery(['name' => 'Sunday'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
