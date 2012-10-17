<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Ray\Di\AbstractModule;

/**
 * Cached annotation reader module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class CachedAnnotationModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->bind('Doctrine\Common\Annotations\Reader')
            ->toProvider('BEAR\Sunday\Module\Provider\CachedReaderProvider');
    }
}
