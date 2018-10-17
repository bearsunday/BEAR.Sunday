<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module;

use BEAR\Sunday\Module\Annotation\DoctrineAnnotationModule;
use BEAR\Sunday\Module\Cache\DoctrineCacheModule;
use BEAR\Sunday\Module\Resource\ResourceModule;
use BEAR\Sunday\Provide\Application\AppModule;
use BEAR\Sunday\Provide\Error\ErrorModule;
use BEAR\Sunday\Provide\Router\RouterModule;
use BEAR\Sunday\Provide\Transfer\HttpCacheModule;
use BEAR\Sunday\Provide\Transfer\HttpResponderModule;
use Ray\Di\AbstractModule;

class SundayModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new AppModule);
        $this->install(new HttpCacheModule);
        $this->install(new DoctrineCacheModule);
        $this->install(new DoctrineAnnotationModule);
        $this->install(new ResourceModule);
        $this->install(new RouterModule);
        $this->install(new HttpResponderModule);
        $this->install(new ErrorModule);
    }
}
