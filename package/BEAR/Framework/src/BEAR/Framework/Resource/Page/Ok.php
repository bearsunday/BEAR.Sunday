<?php
namespace BEAR\Framework\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

class Ok extends Page
{
    public $code = 200;
    public $headers = [];
    public $body = '';

    public function __construct()
    {
    }
}