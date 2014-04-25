<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\HrefInterface;

/**
 * Anchor setter
 */
trait AInject
{
    /**
     * @var HrefInterface
     */
    private $a;

    /**
     * @param HrefInterface $a
     *
     * @Ray\Di\Di\Inject
     */
    public function setAnchor(HrefInterface $a)
    {
        $this->a = $a;
    }
}
