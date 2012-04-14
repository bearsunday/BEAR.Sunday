<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace helloworld;

require dirname(__DIR__) . '/App.php';

$app = App::factory(0);
return $app;