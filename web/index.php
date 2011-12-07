<?php
/**
 * @package BEAR.Framework
 */

include '/path/to/app/script/bootstrap.php';

// page requeset.
$http = $resource->$method->object($page)->linkSelf('view')->eager->request();

// output
include dirname(__DIR__) . '/packages/BEAR.Framework/script/output.php';