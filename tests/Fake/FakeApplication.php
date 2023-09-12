<?php

namespace BEAR\Sunday;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class FakeApplication
{
    public $dir;
    public $id;

    #[Inject]
    public function setPath(#[\Ray\Di\Di\Named('path')]
    $dir): void
    {
        $this->dir = $dir;
    }

    #[Inject]
    public function setId(#[\Ray\Di\Di\Named('id')]
    $id): void
    {
        $this->id = $id;
    }
}
