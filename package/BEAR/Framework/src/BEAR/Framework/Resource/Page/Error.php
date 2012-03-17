<?php
namespace BEAR\Framework\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

class Error extends Page
{
    public $code = 500;
    public $headers = [];
    public $body = '';

    public function __construct()
    {
    }
}