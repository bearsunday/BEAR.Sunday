<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject\Logger;

use Ray\Di\LoggerInterface;
use Ray\Aop\Bind;
use BEAR\Framework\Inject\LogInject;

/**
 * Cache interceptor
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
class Adapter implements LoggerInterface
{
    use LogInject;

    public function log($class, array $params, array $setter, $object, Bind $bind)
    {
        $log = "DI class={$class}"
        . ' params=' . $this->getString((array) $params)
        . ' setter=' . $this->getString((array) $setter)
        . ' bind=' . $this->getString((array) $bind, true);// $this->getString((array) $bind);
        @$this->log->log($log);
    }

    private function getString(array $params, $isBind = false)
    {
        $paramInfo = [];
        foreach ($params as $num => $param) {
            $str = "{$num}:";
            if (is_object($param)) {
                $str .= get_class($param);
            } elseif (is_array($param)) {
                $interceptorsName = [];
                $interceptors = array_values($param);
                foreach ($interceptors as &$interceptor) {
                    $interceptorsName[] = get_class($interceptor);
                }
                $str .= implode(',', $interceptorsName);
            } else {
                $str = json_encode($param);
            }
            $paramInfo[] = $str;
        }
        $paramStr = implode(',', $paramInfo);

        return $paramStr;
    }
}
