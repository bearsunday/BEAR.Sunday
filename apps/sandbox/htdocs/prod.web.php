<?php

use BEAR\Framework\StandardRouter as Router;
use BEAR\Framework\Output\HttpFoundation as Output;

/**
 * Web server script for production
 *
 * @package BEAR.Framework
 */
require dirname(__DIR__) . '/App.php';

// Application
$app = require dirname(__DIR__) . '/scripts/instance.php';

// Route
list($method, $requestUri, $query) = (new Router)->match($GLOBALS);

// Request
$response = $app->resource->$method->uri('page://self/' . $requestUri)->withQuery($query)->linkSelf('view')->eager->request();

// Output
(new Output)->setResource($response)->prepare()->output();