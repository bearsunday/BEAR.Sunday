<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

require dirname(__DIR__) . '/App.php';

$app = App::factory();
return $app;