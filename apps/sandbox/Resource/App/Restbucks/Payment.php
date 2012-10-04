<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\App\Restbucks;

use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Resource\Code;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Payment
 */
class Payment extends AbstractHal
{
    use TmpDirInject;

    public function onGet($id)
    {
        $resourceFile = "{$this->tmpDir}/payment{$id}";
        if (file_exists($resourceFile)) {
            $this->code = 200;

            return $this;
        }
        $this->code = 401;

        return $this;
    }

    /**
     * Put
     *
     * @param int    $id
     * @param string $card_no
     * @param string $expires
     * @param string $name
     * @param int    $amount
     */
    public function onPut($id, $card_no, $expires, $name, $amount)
    {
        // load
        $resourceFile = "{$this->tmpDir}/payment{$id}";
        // update
        $this['card_no'] = $card_no;
        $this['expires'] = $expires;
        $this['name'] = $name;
        $this['amount'] = $amount;
        // 201 creagted
        $this->code = 201;
        // save
        file_put_contents($resourceFile, json_encode($this->body));

        return $this;
    }
}
