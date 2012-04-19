<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\Page;

/**
 * Error page
 * 
 * @package    BEAR.Framework
 * @subpackage Page
 */
 class Error extends AbstractPage
{
    public $code = 500;
    public $headers = [];
    public $body = '';

    /**
     * Constructor
     */
    public function __construct()
    {
    }
}