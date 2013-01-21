<?php
/**
 * mockapp
 *
 * @package BEAR.appmock
 */
namespace mockapp;

use BEAR\Sunday\Application\AppInterface;

/**
 * Applicaton
 *
 * @package App.appmock
 */
final class App implements AppInterface
{
    public $name = __NAMESPACE__;
    public $path = __DIR__;
}
