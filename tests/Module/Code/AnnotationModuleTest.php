<?php

namespace BEAR\Sunday\Module\Code;

use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class AnnotationModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $reader = (new Injector(new AnnotationModule))->getInstance(Reader::class);
        $this->assertInstanceOf(CachedReader::class, $reader);
    }
}
