<?php
require dirname(dirname(dirname(__DIR__))) . '/scripts/instance.php';
require dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/vendor/printo/printo/src.php';

$app = apc_fetch($_GET['app']);
print_o($app);
