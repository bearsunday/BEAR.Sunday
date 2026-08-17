<?php

declare(strict_types=1);

namespace BEAR\Sunday\Compile;

/** A unit of compile work contributed by a module */
interface CompileStepInterface
{
    /**
     * @param non-empty-string $stepDir Named after this step's binding key; the caller creates it
     *
     * @return int Number of artifacts written
     */
    public function __invoke(string $stepDir): int;
}
