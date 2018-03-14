<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Extension\Router;

class RouterMatch
{
    /**
     * Reuqest method
     *
     * @var string
     */
    public $method;

    /**
     * Request path
     *
     * @var string
     */
    public $path;

    /**
     * Request query
     *
     * @var array
     */
    public $query = [];

    /**
     * @return string
     */
    public function __toString()
    {
        $querySymbol = $this->query ? '?' : '';
        $string = "{$this->method} {$this->path}{$querySymbol}" . http_build_query($this->query);

        return $string;
    }
}
