<?php

namespace BEAR\Di\Modules;

use BEAR\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        // resource
        $this->bind('BEAR\Resource\ResourceInterface')->to('BEAR\Resource\Resource');
        $this->bind('BEAR\Di\Provider')->annotatedWith('params')->toProvider('BEAR\Resource\ParamsProvider');
        // web
        $this->bind('BEAR\Web\HeaderInterface')->to('BEAR\Web\Header\Header');
        $this->bind('BEAR\Web\SessionInterface')->to('BEAR\Web\Session\Session');
        // db
        $this->bind('BEAR\App\HelloWorld\DbInterface')->to('BEAR\App\HelloWorld\App\Db');
        $this->bind()->annotatedWith('dsn_slave')->toInstance('dev_user:@localhost/helloworld');
        $this->bind()->annotatedWith('dsn_master')->toInstance('dev_user:@localhost/helloworld');
    }
}