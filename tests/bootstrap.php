<?php

declare(strict_types=1);

use Koriym\Attributes\AttributeReader;
use Ray\ServiceLocator\ServiceLocator;

require dirname(__DIR__) . '/vendor/autoload.php';
array_map('unlink', (array) glob(__DIR__ . '/tmp/*.php')); // @phpstan-ignore-line

// no annotation in PHP 8
ServiceLocator::setReader(new AttributeReader());
