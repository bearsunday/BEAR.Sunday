<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Module\Annotation\DoctrineAnnotationModule;
use BEAR\Sunday\Module\Cache\DoctrineCacheModule;
use BEAR\Sunday\Module\Resource\ResourceModule;
use BEAR\Sunday\Provide\Application\MinApp;
use BEAR\Sunday\Provide\Error\ErrorModule;
use BEAR\Sunday\Provide\Router\RouterModule;
use BEAR\Sunday\Provide\Transfer\HttpResponderModule;
use Ray\Di\AbstractModule;

class SundayModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(AppInterface::class)->to(MinApp::class);
        $this->install(new DoctrineCacheModule);
        $this->install(new DoctrineAnnotationModule);
        $this->install(new ResourceModule);
        $this->install(new RouterModule);
        $this->install(new HttpResponderModule);
        $this->install(new ErrorModule);
    }
}
