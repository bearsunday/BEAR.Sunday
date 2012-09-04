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
class Order extends AbstractObject
{
    use TmpDirInject;

    private $itemList = ['latte' => ['cost' => 250]];

    /**
     * Post
     *
     * @param string $drink
     */
    public function onPost($drink)
    {
        if (! isset($this->itemList[$drink])) {
            // 404 not found
            $this->code = 404;
            return $this;
        }
        $this['drink'] = $drink;
        $this['cost'] = $this->itemList[$drink]['cost'];

        // link
        $id = 1234;
        $this->links['payment'] = [Link::HREF => 'app://self/restbucks/payment/?id=' . $id];
        // 201 created
        $this->code = 201;
        // save
        $storage = "{$this->tmpDir}/order{$id}";
        file_put_contents($storage, json_encode($this->body));
        return $this;
    }

    /**
     * Put
     *
     * @param int    $id
     * @param string $addition
     */
    public function onPut($id, $addition)
    {
        // load
        $storage = "{$this->tmpDir}/order{$id}";
        $this->body = json_decode(file_get_contents($storage), true);
        // update
        $this->body['additon'] = $addition;
        // link
        $this->links['payment'] = [Link::HREF => 'app://self/restbucks/payment/?id=' . $id];
        // 100 continue
        $this->code = 100;
        // save
        file_put_contents($storage, json_encode($this->body));
        return $this;
    }
}
