<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\HrefInterface;
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
     * @var \BEAR\Resource\HrefInterface
     */
    private $a;

    /**
     * A(anchor) setter
     *
     * @param HrefInterface $a
     *
     * @return void
     * @Inject
     */
    public function setAnchor(HrefInterface $a)
    {
        $this->a = $a;
    }
}
