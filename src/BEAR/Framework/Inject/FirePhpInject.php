<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;

/**
 * Inject FirePHP
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait FirePhpInject
{
    /**
     * FirePHP
     *
     * @var string
     */
    private $firephp;

    /**
     * Set firePHP
     *
     * @param FirePHP $firephp
     *
     * @Inject
     */
    public function SetFirePhp(FirePHP $firephp)
    {
        $this->firephp = $firephp;
    }
}
