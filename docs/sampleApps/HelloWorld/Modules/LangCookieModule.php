<?php

namespace BEAR\Di\Modules;

use BEAR\Di\AbstractModule;

class LangCookieModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_lang')->toClosure(
            function(){
                return isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'en';
            }
        );
    }
}