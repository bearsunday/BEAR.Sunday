<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Constant;

use Ray\Di\AbstractModule;

class NamedModule extends AbstractModule
{
    /**
     * @var array
     */
    private $names;

    /**
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

    protected function configure()
    {
        foreach ($this->names as $annotatedWith => $instance) {
            $this->bind()->annotatedWith($annotatedWith)->toInstance($instance);
        }
    }
}
