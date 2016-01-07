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
    public function setPath($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @Inject
     * @Named("id")
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
