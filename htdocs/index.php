<?php
/**
 * index.php
 *
 * @package BEAR.Framework
 */
namespace {appname};

include dirname(__DIR__) . '/script/bootstrap.php';

// page requeset, response.
$http = $resource->$method->object($page)->linkSelf('view')->eager->request();

// http output
include dirname(__DIR__) . '/script/output.php';
