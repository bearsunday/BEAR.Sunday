<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

/**
 * Ok page
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class Ok extends Page
{
    public $code = 200;
    public $headers = [];
    public $body = '';

    public function __construct()
    {
    }
}