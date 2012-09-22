<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\Page;

use ArrayObject;
use ArrayIterator;

/**
 * HTTP Header
 *
 * @package    BEAR.Framework
 * @subpackage Page
 */
final class Header extends ArrayObject
{
    public function getIterator()
    {
        return new ArrayIterator((array) $this);
    }

    public function outout()
    {
        iterator_apply(
            $this->getIterator(),
            function ($header){
                header($header);
            }
        );
    }

    public function outoutAsString()
    {
        iterator_apply(
            $this->getIterator(),
            function ($header){
                echo "$header\n";
            }
        );
    }
}
