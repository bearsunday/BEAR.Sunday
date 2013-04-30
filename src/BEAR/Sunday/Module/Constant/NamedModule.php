<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Constant;

use Ray\Di\AbstractModule;

/**
 * Constants 'Named' module
 */
class NamedModule extends AbstractModule
{
    /**
     * Constructor
     *
     * @param array $names
     */
    public function __construct(array $names)
    {
        $names += [
            'sunday_dir' =>dirname(dirname(dirname(dirname(dirname(__DIR__)))))
        ];
        $this->names = $names;
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        foreach ($this->names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}
