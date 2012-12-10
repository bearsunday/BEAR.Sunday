<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cache;

use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;

/**
 * Cache module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ApcModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Sunday\Module\Provider\ApcCacheProvider')->in(Scope::SINGLETON);
    }
}
