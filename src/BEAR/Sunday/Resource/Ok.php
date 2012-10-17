<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Resource\AbstractObject;

/**
 * Ok page
 *
 * @package    BEAR.Sunday
 * @subpackage Page
 */
final class Ok extends AbstractObject implements ResourceObject
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
