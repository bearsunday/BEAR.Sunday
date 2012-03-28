<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\View;

use Smarty;

/**
 * Smarty adapter
 *
 * @package    BEAR.Framework
 * @subpackage View
 * @author     Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class SmartyAdapter implements Renderable
{
    use fileExists;

    /**
     * @var Smarty
     */
    private $renderer;

    const EXT = 'tpl';

    /**
     * Constructor
     */
    public function __construct()
    {
//         $this->renderer = new Smarty;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::assign()
     */
    public function assign()
    {
        $args = func_get_args();
        $count = count($args);
        if ($count === 1) {
            $this->renderer->assign($args[0]);
        } elseif ($count === 2) {
            $this->renderer->assign($args[0], $args[1]);
        } else {
            throw \InvalidArgumentException;
        }
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::fetch()
     */
    public function fetch($templateFileBase)
    {
        $template = $templateFileBase . self::EXT;
        $this->fileExists($template);
        return $this->renderer->fetch($template);
    }
}
