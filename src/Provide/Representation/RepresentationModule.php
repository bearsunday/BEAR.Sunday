<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Representation;

use Ray\Di\AbstractModule;
use BEAR\Resource\RenderInterface;
use BEAR\Resource\JsonRenderer;

class RepresentationModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(RenderInterface::class)->to(JsonRenderer::class);
    }
}
