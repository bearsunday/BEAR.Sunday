<?php
namespace helloworld;

use BEAR\Framework\Dispatcher;

/**
 * Minimum Hello World
 *
 * no router
 * no view
 * no app resource
 * no page object graph cache
 */

require dirname(__DIR__) . '/scripts/auto_loader.php';

// Request
$resource = require dirname(__DIR__). '/scripts/resource.php';
$response = $resource->get->uri('page://self/hello')->withQuery(['name' => 'Sunday, Basic.'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
echo number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4);
exit(0);