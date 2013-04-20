<?php
/**
 * This file is part of the {package} package
 *
 * @package {package}
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

namespace BEAR\Sunday\Module\DependencyInjection;

use Ray\Di\Module\InjectorModule;
use Doctrine\Common\Annotations\AnnotationReader;
use Ray\Di\Injector;

class InjectorModuleTest extends \PHPUnit_Framework_TestCase {

    private $instance;

    protected function setUp()
    {
        AnnotationReader::addGlobalIgnoredName('noinspection');
        $this->instance = Injector::create(
            [
                new InjectorModule
            ]
        )->getInstance('Ray\Di\Injector');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('Ray\Di\Injector', $this->instance);
    }
}
