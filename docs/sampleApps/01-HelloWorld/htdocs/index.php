<?php
/**
 * With bootscript
 * 
 * Bootscript determine page object as page controller as well as
 * request $method and $query by WebContext.
 * 
 */
namespace BEAR\App\HelloWorld;
require '/path/to/BEAR.Sunday/scripts/bootscrap.php';

//
// These variable is set by web context in bootstrap.
//
// Page   $paeg
// array  $query
// string $mthod

try {
    $resource->object($page)->link('html')->link('http')->$method($query);
} catch (Exception $e) {
    echo $e;
    exit(1);
}