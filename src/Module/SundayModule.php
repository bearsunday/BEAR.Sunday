<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use BEAR\Sunday\Module\Cache\DoctrineCacheModule;
use BEAR\Sunday\Module\Annotation\DoctrineAnnotationModule;
use BEAR\Sunday\Module\Cache\ResourceModule;
use Ray\Di\AbstractModule;

class SundayModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new DoctrineCacheModule);
        $this->install(new DoctrineAnnotationModule);
        $this->install(new ResourceModule);
    }
}
