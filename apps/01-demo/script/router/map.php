<?php
/**
 * Route Map
 *
 * @global \Aura\Router\Map $map
 */
namespace BEAR\Application\Script;

$map = require dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/Aura.Router/scripts/instance.php';
$map->attach('/helloresource', [
    'routes' => [
        // GET
        'get' => [
            'path' => '/{:lang}',
            'values' => [
                'page' => 'helloresource'
            ],
        ]
    ]
]);
return $map;