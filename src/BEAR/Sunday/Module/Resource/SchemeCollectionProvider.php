<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\SchemeCollection;
use Ray\Di\ProviderInterface;

/**
 * Scheme collection
 *
 * @package BEAR.Sunday
 * @see     https://github.com/auraphp/Aura.Web.git
 */
class SchemeCollectionProvider implements ProviderInterface
{
    /**
     * Return instance
     *
     * @return SchemeCollection
     */
    public function get()
    {
        return new SchemeCollection;
    }
}
