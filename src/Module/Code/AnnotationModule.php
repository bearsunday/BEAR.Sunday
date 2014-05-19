<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class AnnotationModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Doctrine\Common\Annotations\Reader')
            ->to('Doctrine\Common\Annotations\AnnotationReader')
            ->in(Scope::SINGLETON);
    }
}
