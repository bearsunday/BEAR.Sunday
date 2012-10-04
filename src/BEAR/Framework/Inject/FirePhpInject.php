<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Di\Inject;

// @codingStandardsIgnoreFile
/**
 * Inject FirePHP
 *
 * @package BEAR.Framework
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
