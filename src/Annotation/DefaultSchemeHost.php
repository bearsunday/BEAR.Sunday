<?php

declare(strict_types=1);

namespace BEAR\Sunday\Annotation;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
final class DefaultSchemeHost
{
    public $value;
}
