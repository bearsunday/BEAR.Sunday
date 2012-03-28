<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\View;

interface Renderable
{
    public function assign();
    public function fetch($template);
}