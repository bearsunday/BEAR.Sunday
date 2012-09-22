<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\Page;

/**
 * Ok page
 *
 * @package    BEAR.Framework
 * @subpackage Page
 */
final class Ok extends AbstractPage
{
    public $code = 200;
    public $headers = [];
    public $body = '';

    public function __construct()
    {
    }
}
