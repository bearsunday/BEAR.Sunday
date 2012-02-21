<?php
/**
 * Minimum Hello World
 *
 * no router
 * no dispatcher
 * no model (app resource)
 * no template engine
 * no cache
 */
require dirname(__DIR__) . '/scripts/auto_loader.php';

// dependency injector
$di = require dirname(__DIR__) . '/scripts/di.php';

// resource request
$response = $di->getInstance('\BEAR\Resource\Client')->get->uri('page://self/hello')->withQuery(['name' => 'Sunday'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
exit(0);