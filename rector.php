<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Ray\AnnotationBinding\Rector\ClassMethod\AnnotationBindingRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/src-deprecated',
        __DIR__ . '/tests',
    ]);
    $rectorConfig->skip([
        __DIR__ . '/src/*Interface.php',
        __DIR__ . '/tests/Provide/Error/ThrowableHandlerTest.php'
    ]);

    // register a single rule
    $rectorConfig->rule(AnnotationBindingRector::class);
    $rectorConfig->rule(AnnotationBindingRector::class);

    // define sets of rules
        $rectorConfig->sets([
            LevelSetList::UP_TO_PHP_80
        ]);
};
