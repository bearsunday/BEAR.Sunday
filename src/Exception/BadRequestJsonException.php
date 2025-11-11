<?php

declare(strict_types=1);

namespace BEAR\Sunday\Exception;

use BEAR\Resource\Exception\BadRequestException;

final class BadRequestJsonException extends BadRequestException implements ExceptionInterface
{
}
