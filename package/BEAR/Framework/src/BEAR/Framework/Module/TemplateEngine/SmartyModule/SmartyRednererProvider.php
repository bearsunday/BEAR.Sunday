<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\TemplateEngine\SmartyModule;

use BEAR\Framework\Resource\View\Renderer;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Smarty;

/**
 * Smarty renderer adapter
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SmartyRednererProvider implements Provide
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
     * Return instance
     *
     * @return Renderer
     */
    public function get()
    {
        $instance = new Renderer($this->adapter);
        return $instance;
    }
}