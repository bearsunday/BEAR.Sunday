<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace sandbox;

use BEAR\Framework\AbstractAppContext as AppContext;

/**
 * Applicaton
 *
 * @package App.sandbox
 */
final class App extends AppContext
{
    /**
     * Version
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * Name
     *
     * @var string
     */
    public $name;

    /**
     * Path
     *
     * @var string
     */
    public $path;

    /**
     * Constructor
     *
     * @param string $appName
     */
    public function __construct($appName = __NAMESPACE__)
    {
        $this->name = $appName;
        $this->path = __DIR__;
    }
}
