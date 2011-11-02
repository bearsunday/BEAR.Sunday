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

try {
    $resource->$method($page, $query)->link('html')->link('http');
} catch (\Exception $e) {
    echo $e;
    exit(1);
}