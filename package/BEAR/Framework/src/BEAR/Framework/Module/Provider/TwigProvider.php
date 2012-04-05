<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;

/**
 * Twig
 *
 * @see http://twig.sensiolabs.org/
 */
class TwigProvider implements ProviderInterface
{
    /**
     * @return array
     */
    public function get()
    {
        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem('/'),
            [
                'cache' => dirname(dirname(__DIR__)) . '/tmp/twig',
                'auto_reload' => true
            ]
        );
        return $twig;
    }
}