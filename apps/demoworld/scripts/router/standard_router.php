<?php
/**
 * Standard Router
 *
 * @global \Aura\Router\Map $map
 * @global array            $globals
 * @global array            $pageUri
 * @global array            $query
 */
namespace BEAR\Application\Script;

use BEAR\Framework\StandardRouter;
use Aura\Router\Map,
    Aura\Router\RouteFactory;

// get a routes array from each application packages
$attach = [
    '/helloresource'  => require __DIR__ . '/routes/helloresource.php',
];
// create a Map with attached route groups
$map = new Map(new RouteFactory, $attach);
$standardRouter = new StandardRouter($map);
return $standardRouter;
