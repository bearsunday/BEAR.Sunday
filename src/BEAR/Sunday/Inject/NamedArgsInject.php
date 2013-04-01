<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Aop\NamedArgsInterface;
use Ray\Di\Di\Inject;

/**
 * Inject named parameter converter
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait NamedArgsInject
{
    /**
     * Named dir
     *
     * @var string
     */
    private $namedArgs;

    /**
     * Set tmp dir path
     *
     * @param string $tmpDir
     *
     * @Ray\Di\Di\Inject
     */
    public function setNamedArgs(NamedArgsInterface $namedArgs)
    {
        $this->namedArgs = $namedArgs;
    }
}
