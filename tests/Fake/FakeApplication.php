<?php

namespace BEAR\Sunday;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class FakeApplication
{
    public $dir;
    public $id;

    /**
     * @Inject
     * @Named("path")
     */
    public function setPath($dir): void
    {
        $this->dir = $dir;
    }

    /**
     * @Inject
     * @Named("id")
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
