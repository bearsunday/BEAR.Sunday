<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';
array_map('unlink', (array) glob(__DIR__ . '/tmp/*.php'));
