<?php

namespace demoWorld\Module\Provider;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;

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
                'cache' => dirname(__DIR__) . '/tmp/twig',
                'auto_reload' => true
            ]
        );
        return $twig;
    }
}