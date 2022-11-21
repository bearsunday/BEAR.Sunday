<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\NullResourceObject;
use BEAR\Sunday\Extension\Transfer\NullTransfer;
use PHPUnit\Framework\TestCase;

class NullTransferTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testNullError(): void
    {
        (new NullTransfer())(new NullResourceObject(), []);
    }
}
