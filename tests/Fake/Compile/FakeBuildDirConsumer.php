<?php

declare(strict_types=1);

namespace BEAR\Sunday\Compile;

use BEAR\Sunday\Compile\Annotation\BuildDir;

final class FakeBuildDirConsumer
{
    public function __construct(
        #[BuildDir]
        public readonly string $buildDir,
    ) {
    }
}
