<?php
/**
 * Sandbox
 *
 * @package App.Sandbox
 */
namespace Helloworld;

require_once dirname(dirname(dirname(__DIR__))) . '/src/BEAR/Framework/Framework/Framework.php';
require_once dirname(__DIR__) . '/App.php';

$app = App::factory(App::RUN_MODE_PROD, true);
return $app;
