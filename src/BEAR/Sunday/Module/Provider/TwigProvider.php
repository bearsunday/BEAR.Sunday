<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use BEAR\Sunday\Inject\TmpDirInject;
use Ray\Di\ProviderInterface;
use Twig_Environment;

/**
 * Twig
 *
 * @see http://twig.sensiolabs.org/
 */
class TwigProvider implements ProviderInterface
{
    use TmpDirInject;

    /**
     * Return twig instance
     *
     * @return Twig_Environment
     */
    public function get()
    {
        $twig = new Twig_Environment(
            new \Twig_Loader_Filesystem('/'),
            [
                'cache' => $this->tmpDir . '/tmp/twig',
                'auto_reload' => true
            ]
        );

        return $twig;
    }
}
