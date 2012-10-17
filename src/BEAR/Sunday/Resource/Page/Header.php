<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\Page;

use ArrayObject;
use ArrayIterator;

/**
 * HTTP Header
 *
 * @package    BEAR.Sunday
 * @subpackage Page
 */
final class Header extends ArrayObject
{
    /**
     * (non-PHPdoc)
     * @see ArrayObject::getIterator()
     */
    public function getIterator()
    {
        return new ArrayIterator((array)$this);
    }

    /**
     * Output
     *
     * @return void
     */
    public function output()
    {
        iterator_apply(
            $this->getIterator(),
            function ($header) {
                header($header);
            }
        );
    }

    /**
     * Output as string
     *
     * @return void
     */
    public function outputAsString()
    {
        iterator_apply(
            $this->getIterator(),
            function ($header) {
                echo "$header\n";
            }
        );
    }
}
