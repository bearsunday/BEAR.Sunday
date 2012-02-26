<?php
/**
 * Standard Router
 *
 * @global \Aura\Router\Map $map
 * @global array            $globals
 * @global array            $pageResource
 * @global array            $query
 */
namespace BEAR\Application\Script;

use BEAR\Framework\DevRouter;

// set $globals
if  (PHP_SAPI !== 'cli') {
    $globals = $GLOBALS;
} else {
    if (!isset($argv[1]) || !isset($argv[2])) {
        echo 'usage: <method> <uri>' . PHP_EOL;
        exit(1);
    }
    $globals = [
        '_GET' => [DevRouter::METHOD_OVERRIDE => $argv[1]],
        '_SERVER' => ['REQUEST_URI' => $argv[2]]
    ];
}

list($method, $pageResource) = (new DevRouter($globals))->get();
$parsedUrl = parse_url($globals['_SERVER']['REQUEST_URI']);
if (isset($parsedUrl['query'])) {
    parse_str(parse_url($argv[2])['query'], $query);
} else {
    $query = [];
}

return [$method, $pageResource, $query];
