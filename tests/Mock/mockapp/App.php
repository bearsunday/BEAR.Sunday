<?php
/**
 * mockapp
 *
 * @package BEAR.appmock
 */
namespace mockapp;

use BEAR\Sunday\Application\Context;

/**
 * Applicaton
 *
 * @package App.appmock
 */
final class App implements Context
{
    public $name = __NAMESPACE__;
    public $path = __DIR__;
}
