<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module\Constant;

use Ray\Di\AbstractModule;

class NamedModule extends AbstractModule
{
    /** @param array<string, string> $names */
    public function __construct(
        private array $names,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        foreach ($this->names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}
