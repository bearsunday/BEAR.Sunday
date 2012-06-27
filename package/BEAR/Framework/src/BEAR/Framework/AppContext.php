<?php
/**
 * AbstractAppContext
 *
 * @package BEAR.Framework
 */
namespace BEAR\Framework;

/**
 * Application context
 *
 * @package    BEAR.Framework
 * @subpackage App
 */
interface AppContext
{
    public static function factory($runMode, $useCache = false);
}
