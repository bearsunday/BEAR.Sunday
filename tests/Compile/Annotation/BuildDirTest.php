<?php

declare(strict_types=1);

namespace BEAR\Sunday\Compile\Annotation;

use Attribute;
use BEAR\Sunday\Compile\FakeBuildDirConsumer;
use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use ReflectionClass;

class BuildDirTest extends TestCase
{
    public function testQualifiesConstructorParameter(): void
    {
        $module = new class extends AbstractModule {
            protected function configure(): void
            {
                $this->bind()->annotatedWith(BuildDir::class)->toInstance('/app/var/build/prod');
            }
        };

        $consumer = (new Injector($module))->getInstance(FakeBuildDirConsumer::class);

        $this->assertSame('/app/var/build/prod', $consumer->buildDir);
    }

    public function testTargetsParameterOnly(): void
    {
        $attributes = (new ReflectionClass(BuildDir::class))->getAttributes(Attribute::class);

        $this->assertSame(Attribute::TARGET_PARAMETER, $attributes[0]->newInstance()->flags);
    }
}
