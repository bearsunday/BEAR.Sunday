<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/MIT MIT
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

    /**
     * @return string
     */
    public function __toString()
    {
        $querySymbol = $this->query ? '?' : '';
        $string = "{$this->method} {$this->path}{$querySymbol}".http_build_query($this->query);

        return $string;
    }
}
