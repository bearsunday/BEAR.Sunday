<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Router;

/**
 * Scheme+Host value object
 *
 * ex) page://self/
 */
final class SchemeHost
{
    /**
     * @var string
     */
    private $schemeHost;

    public function __construct($schemeHost)
    {
        $this->schemeHost = (string) $schemeHost;
    }

    public function __toString()
    {
        return $this->schemeHost;
    }
}
