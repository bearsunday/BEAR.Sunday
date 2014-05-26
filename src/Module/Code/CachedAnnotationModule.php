<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class CachedAnnotationModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Doctrine\Common\Annotations\Reader')
            ->toProvider('BEAR\Sunday\Module\Code\CachedReaderProvider')
            ->in(Scope::SINGLETON);
        $this
            ->bind('Doctrine\Common\Annotations\CachedReader')
            ->toProvider('BEAR\Sunday\Module\Code\CachedReaderProvider')
            ->in(Scope::SINGLETON);
    }
}
