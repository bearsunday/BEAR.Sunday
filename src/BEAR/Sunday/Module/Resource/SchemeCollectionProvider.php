<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\SchemeCollection;
use Ray\Di\ProviderInterface;

/**
 * Scheme collection
 */
class SchemeCollectionProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @return SchemeCollection
     */
    public function get()
    {
        return new SchemeCollection;
    }
}
