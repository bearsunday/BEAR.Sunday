<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\NullResourceObject;
use BEAR\Sunday\Extension\Transfer\NullHttpCache;
use BEAR\Sunday\Extension\Transfer\NullTransfer;
use PHPUnit\Framework\TestCase;

class NullHttpCacheTest extends TestCase
{
    public function testNullError()
    {
        $httpCache = new NullHttpCache;
        $this->assertFalse($httpCache->isNotModified([]));
        $this->assertNull($httpCache->transfer());
    }
}
