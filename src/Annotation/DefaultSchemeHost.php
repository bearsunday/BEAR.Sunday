<?php

declare(strict_types=1);

namespace BEAR\Sunday\Annotation;

use Attribute;
use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
#[Attribute(Attribute::TARGET_METHOD), Qualifier]
final class DefaultSchemeHost implements NamedArgumentConstructorAnnotation
{
    /** @var ?string */
    public $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }
}
