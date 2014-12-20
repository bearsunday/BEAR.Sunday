<?php

use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);

return $app;
