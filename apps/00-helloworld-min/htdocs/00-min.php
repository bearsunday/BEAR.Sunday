<?php
// define
$appPath = dirname(__DIR__);

/**
 * Minimum Hello World
 *
 * no router (use Apache)
 * no view
 * no app resource
 * no page object graph cache
 */

require $appPath . '/script/auto_loader.php';
$di = require $appPath . '/script/di.php';

// resource request
$response = $di->getInstance('\BEAR\Resource\Client')->get->uri('page://self/hello')->withQuery(['name' => 'Sunday'])->eager->request();
// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;