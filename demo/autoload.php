<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;

$autoload = require dirname(__DIR__) . '/vendor/autoload.php';
assert($autoload instanceof ClassLoader);
$autoload->addPsr4('MyVendor\HelloWorld\\', __DIR__ . '/src');
