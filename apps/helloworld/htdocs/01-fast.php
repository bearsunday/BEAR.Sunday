<?php
namespace helloWorld;

/**
 * Minimum Hello World
 *
 * no router
 * no view
 * no app resource
 * no page object graph cache
 */
// include $appPath . '/script/utility/clear_cache.php';

require dirname(__DIR__) . '/src.php';
// require dirname(__DIR__) . '/script/auto_loader.php';

list($resource, $page) = (new \BEAR\Framework\Dispatcher(__NAMESPACE__, dirname(__DIR__)))->getInstance('hello');

$response = $resource->get->object($page)->withQuery(['name' => 'Sunday'])->eager->request();

// output
foreach ($response->headers as $header) {
    header($header);
}
echo $response->body;
exit(0);