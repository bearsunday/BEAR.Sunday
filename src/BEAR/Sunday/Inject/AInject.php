<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\Referable;
use Ray\Di\Di\Inject;


/**
 * Inject A(anchor)
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait AInject
{
    /**
     * App directory path
     *
     * @var \BEAR\Resource\A
     */
    private $a;

    /**
     * A(anchor) setter
     *
     * @param Referable $a
     *
     * @return void
     * @Inject
     */
    public function setAnchor(Referable $a)
    {
        $this->a = $a;
    }
}
