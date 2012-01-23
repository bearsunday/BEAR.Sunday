<?php
/**
 * Route Map
 */
namespace BEAR\Application\Script;

$attach = [
    'routes' => [
        'get' => '/{:lang}',
    ],
	'values' => [
        'page' => 'helloresource'
    ]
];
return $attach;