<?php
namespace sandbox\Resource\App\Restbucks;

use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Resource\AbstractObject;
use BEAR\Framework\Resource\Link;
use BEAR\Resource\Code;
use BEAR\Resource\Uri;

/**
 * Greeting resource
 */
class Payment extends AbstractObject
{
    use TmpDirInject;

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
        $storage = "{$this->tmpDir}/payment{$id}";
        // update
        $this->body['card_no'] = $card_no;
        $this->body['expires'] = $expires;
        $this->body['name'] = $name;
        $this->body['amount'] = $amount;
        // 201 creagted
        $this->code = 201;
        // save
        file_put_contents($storage, json_encode($this->body));
        return $this;
    }
}
