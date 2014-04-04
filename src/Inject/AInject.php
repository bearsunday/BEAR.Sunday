<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\HrefInterface;

/**
 * Inject A(anchor)
 */
trait AInject
{
    /**
     * App directory path
     *
     * @var HrefInterface
     */
    private $a;

    /**
     * A(anchor) setter
     *
     * @param HrefInterface $a
     *
     * @return void
     * @Ray\Di\Di\Inject
     */
    public function setAnchor(HrefInterface $a)
    {
        $this->a = $a;
    }
}
