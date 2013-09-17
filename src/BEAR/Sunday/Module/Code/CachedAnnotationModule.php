<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Ray\Di\AbstractModule;

/**
 * Cached annotation reader module
 */
class CachedAnnotationModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Doctrine\Common\Annotations\Reader')
            ->toProvider('BEAR\Sunday\Module\Code\CachedReaderProvider');
    }
}
