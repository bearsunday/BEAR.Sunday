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
use Smarty;

class SmartyRednererProvider implements ProviderInterface
{
    /**
     * @param Smarty $smarty
     *
     * @Inject
     */
    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     *
     * @return \BEAR\Framework\Resource\View\Renderer
     */
    public function get()
    {
        $instance = new Renderer(new SmartyAdapter($this->smarty));
        return $instance;
    }
}