<?php
/**
 * demoworld
 *
 * @package App.demoworld
 */
namespace demoworld;

use BEAR\Framework\AbstractAppContext as AppContext;
use BEAR\Framework\Framework;

/**
 * Applicaton
 *
 * @package App.demoworld
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
}
