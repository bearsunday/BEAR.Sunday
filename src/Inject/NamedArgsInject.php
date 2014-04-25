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
 * Named parameter converter setter
 */
trait NamedArgsInject
{
    /**
     * @var string
     */
    private $namedArgs;

    /**
     * @param NamedArgsInterface $namedArgs
     * @Ray\Di\Di\Inject
     */
    public function setNamedArgs(NamedArgsInterface $namedArgs)
    {
        $this->namedArgs = $namedArgs;
    }
}
