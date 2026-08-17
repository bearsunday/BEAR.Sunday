<?php

declare(strict_types=1);

namespace BEAR\Sunday\Compile\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/** Where the build writes: read-only while serving. */
#[Attribute(Attribute::TARGET_PARAMETER)]
#[Qualifier]
final class BuildDir
{
}
