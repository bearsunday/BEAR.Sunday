<?php
/**
 * mockapp
 *
 * @package BEAR.appmock
 */
namespace mockapp;

use BEAR\Framework\AbstractAppContext as AppContext;

/**
 * Applicaton
 *
 * @package App.appmock
 */
final class App extends AppContext
{
    public $name = __NAMESPACE__;
    public $path = __DIR__;
}
