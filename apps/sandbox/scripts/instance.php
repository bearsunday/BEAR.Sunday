<?php
/**
 * App instance
 */
namespace sandbox;

require_once dirname(dirname(dirname(__DIR__))) . '/src/BEAR/Framework/src.php';
require_once dirname(__DIR__) . '/App.php';

$app = App::factory(App::RUN_MODE_PROD, true);
return $app;
