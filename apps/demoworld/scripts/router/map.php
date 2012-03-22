<?php
/**
 * Route Map
 *
 * @global \Aura\Router\Map $map
 */
namespace BEAR\Application\Script;

$map = require dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/Aura.Router/scripts/instance.php';
$attach = [
    '/helloresource'  => require __DIR__ . '/routes/helloresource.php',
];
$map->attach($attach);
return $map;