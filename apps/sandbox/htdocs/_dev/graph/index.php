<?php
require dirname(dirname(dirname(__DIR__))) . '/scripts/instance.php';
require dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/vendor/print_o/print_o/print_o/src.php';

$app = apc_fetch($_GET['app']);
print_o($app);
