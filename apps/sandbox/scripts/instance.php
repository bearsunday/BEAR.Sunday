<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

require dirname(__DIR__) . '/App.php';

$app = App::factory(App::RUN_MODE_PROD, true);
return $app;
