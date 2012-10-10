<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\Page;

/**
 * Error page
 *
 * @package    BEAR.Sunday
 * @subpackage Page
 */
final class Error extends AbstractPage
{
    /**
     * Code
     *
     * @var int
     */
    public $code = 500;

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
}
