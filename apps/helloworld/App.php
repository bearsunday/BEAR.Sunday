<?php
/**
 * helloworld
 *
 * @package App.helloworld
 */
namespace helloworld;

use BEAR\Framework\AbstractAppContext as AppContext;
use BEAR\Framework\Framework;

/**
 * Applicaton
 *
 * @package App.helloworld
 */
final class App extends AppContext
{
    /**
     * Version
     *
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * Name
     *
     * @var string
     */
    public $name = __NAMESPACE__;

    /**
     * Path
     *
     * @var string
     */
    public $path = __DIR__;

//     public function __construct()
//     {
//     }
}
