<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Mock\ResourceObject;

use BEAR\Resource\ResourceObject;

/**
 * Ok page
 *
 * @package    BEAR.Sunday
 * @subpackage Page
 */
final class Ok extends AbstractObject
{
    /**
     * Code
     *
     * @var int
     */
    public $code = 200;

    /**
     * Headers
     *
     * @var array
     */
    public $headers = [];

    /**
     * Body
     *
     * @var mixed
     */
    public $body = '';

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get
     *
     * @return $this
     */
    public function onGet()
    {
        return $this;
    }
}
