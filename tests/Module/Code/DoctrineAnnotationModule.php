<?php
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Module\Code;

use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class DoctrineAnnotationModule extends TestCase
{
    public function testGetInstance()
    {
        $reader = (new Injector)->getInstance(Reader::class);
        $this->assertInstanceOf(CachedReader::class, $reader);
    }
}
