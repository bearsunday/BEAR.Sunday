<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\App;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Performance extends AbstractObject
{
    /**
     * Get
     *
     * @param string $lang
     *
     * @return float
     */
    public function onGet()
    {
        $performance = number_format((1 / (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])), 2);

        return $performance;
    }
}
