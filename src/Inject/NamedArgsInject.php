<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Aop\NamedArgsInterface;
use Ray\Di\Di\Inject;

/**
 * Inject named parameter converter
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
     * Set named arg
     *
     * @param NamedArgsInterface $namedArgs
     * @Ray\Di\Di\Inject
     */
    public function setNamedArgs(NamedArgsInterface $namedArgs)
    {
        $this->namedArgs = $namedArgs;
    }
}
