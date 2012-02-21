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
// include $appPath . '/scripts/utility/clear_cache.php';

require dirname(__DIR__) . '/scripts/auto_loader.php';

list($resource, $page) = (new Dispatcher(new App(__NAMESPACE__)))->getInstance('hello');

$response = $resource->get->object($page)->withQuery(['name' => 'Sunday'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
exit(0);