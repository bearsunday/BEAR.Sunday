<?php

namespace BEAR\Sunday\Module\Annotation;

use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Ray\Di\Injector;

class AnnotationModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $reader = (new Injector(new DoctrineAnnotationModule))->getInstance(Reader::class);
        $this->assertInstanceOf(CachedReader::class, $reader);
    }
}
