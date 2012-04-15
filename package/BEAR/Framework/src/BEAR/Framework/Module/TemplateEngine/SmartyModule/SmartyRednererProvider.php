<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\TemplateEngine\SmartyModule;

use BEAR\Framework\Resource\View\Renderer;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Smarty;

class SmartyRednererProvider implements ProviderInterface
{
    /**
     * @param SmartyAdapter $adapter
     * 
     * @Inject
     */
    public function setAdapter(SmartyAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
    /**
     *
     * @return \BEAR\Framework\Resource\View\Renderer
     */
    public function get()
    {
        $instance = new Renderer($this->adapter);
        return $instance;
    }
}