<?php
/**
 * CLI / Built-in web server script for API.
 *
 * @package BEAR.Framework
 *
 * @global string               $method   Resource rquest method
 * @global BEAR\Resource\Client $resource Resource client
 * @global array                $query    Resource request query
 * @global BEAR\Resource\Object $page     Resource object (target)
 * @global BEAR\Resource\Object $response Resource object (response)
 */
use BEAR\Resource\Object as ResourceObject;

include dirname(__DIR__) . '/script/api.bootstrap.php';

$response = $resource->$method->object($ro)->withQuery($query)->eager->request();

if (!($response instanceof ResourceObject)) {
    $ro->body = $response;
    $response = $ro;
}

include $appPath . '/script/output/api.output.php';