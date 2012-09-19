<?php
namespace sandbox\Resource\App\Restbucks;

use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Resource\Link;
use BEAR\Resource\Code;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Order
 */
class Order extends AbstractHal
{
    use TmpDirInject;

    /**
     * Menu
     *
     * @var unknown_type
     */
    private $itemList = [
        'latte' => ['cost' => 2.5],
        'tea' => ['cost' => 2.0]
    ];

    /**
     * Get
     *
     * @param int $id order id
     */
    public function onGet($id)
    {
        // load
        $resourceFile = "{$this->tmpDir}/order{$id}";
        $this->body = json_decode(file_get_contents($resourceFile), true);
    }

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
        $id = date('is'); // min+sec
        $this['id'] = $id;
        $this->links['payment'] = [Link::HREF => 'app://self/restbucks/payment?id=' . $id];
        // 201 created
        $this->code = 201;
        // save
        $resourceFile = "{$this->tmpDir}/order{$id}";
        file_put_contents($resourceFile, (string) $this);

        return $this;
    }

    /**
     * Put
     *
     * @param int    $id       order id
     * @param string $addition additonal order
     */
    public function onPut($id, $addition = null, $status = null)
    {
        // load
        $resourceFile = "{$this->tmpDir}/order{$id}";
        $this->body = json_decode(file_get_contents($resourceFile), true);
        // update
        if ($addition) {
            $this['additon'] = $addition;
        }
        if ($status) {
            $this['status'] = $status;
        }
        // link
        $this->links['payment'] = [Link::HREF => 'app://self/restbucks/payment?id=' . $id];
        // 100 continue
        $this->code = 100;
        // save
        file_put_contents($resourceFile, (string) $this);

        return $this;
    }

    /**
     * Delete
     *
     * @param int $id order id
     */
    public function onDelete($id)
    {
        $resourceFile = "{$this->tmpDir}/order{$id}";
        @unlink($resourceFile);
        $this->code = 200;

        return $this;
    }

}
