<?php
/**
 * mockapp
 *
 * @package BEAR.appmock
 */
namespace mockapp;

use BEAR\Sunday\Application\ContextInterface;

/**
 * Applicaton
 *
 * @package App.appmock
 */
final class App implements ContextInterface
{
    public $name = __NAMESPACE__;
    public $path = __DIR__;
}
