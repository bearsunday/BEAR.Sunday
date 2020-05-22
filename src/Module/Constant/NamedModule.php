<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module\Constant;

use Ray\Di\AbstractModule;

class NamedModule extends AbstractModule
{
    /**
     * @var array<string, string>
     */
    private $names;

    /**
     * @param array<string, string> $names
     */
    public function __construct(array $names)
    {
        $this->names = $names;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        foreach ($this->names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}
