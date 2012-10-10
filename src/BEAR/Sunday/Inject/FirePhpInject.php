<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\Di\Inject;

// @codingStandardsIgnoreFile
/**
 * Inject FirePHP
 *
 * @package BEAR.Sunday
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
