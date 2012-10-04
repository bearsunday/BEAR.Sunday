<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider as Provide;

use BEAR\Sunday\Inject\TmpDirInject;

/**
 * Twig
 *
 * @see http://twig.sensiolabs.org/
 */
class TwigProvider implements Provide
{
    use TmpDirInject;

    /**
     * Return twig instace
     *
     * @return Twig_Environment
     */
    public function get()
    {
        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem('/'),
            [
                'cache' => $this->tmpDir . '/tmp/twig',
                'auto_reload' => true
            ]
        );

        return $twig;
    }
}
