<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

/**
 * Application module for API
 *
 * @package    sandbox
 * @subpackage Module
 */
class ApiModule extends ProdModule
{
    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
    }
}