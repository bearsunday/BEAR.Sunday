<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Router;

class RouterMatch
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $query = [];

    public function __toString()
    {
        $querySymbol = $this->query ? '?' : '';
        $string = "{$this->method} {$this->path}{$querySymbol}".http_build_query($this->query);

        return $string;
    }
}
