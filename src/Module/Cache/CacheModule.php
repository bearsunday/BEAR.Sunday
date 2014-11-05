<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cache;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class CacheModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Doctrine\Common\Cache\Cache')
            ->toProvider(__NAMESPACE__ . '\CacheProvider')
            ->in(Scope::SINGLETON);
    }
}
