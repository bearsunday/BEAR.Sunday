<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\AbstractModule;

/**
 * Named module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class NamedModule extends AbstractModule
{
    /**
     *
     * @param array $names
     */
    public function __construct(array $names)
    {
        $this->names = $names;
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        foreach ($names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}
