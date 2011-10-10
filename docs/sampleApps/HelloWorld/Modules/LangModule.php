<?php

namespace BEAR\Di\Modules;

use BEAR\Di\AbstractModule;

class LangModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('user_lang')->toInstance('en');
    }
}