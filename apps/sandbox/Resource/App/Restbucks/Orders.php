<?php
namespace sandbox\Resource\App\Restbucks;

use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Resource\AbstractObject;
use BEAR\Resource\Link;
use DirectoryIterator;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Orders
 */
class Orders extends AbstractObject
{
    use TmpDirInject;

    public function onGet()
    {
        // load
        $this->loadOrder();

        return $this;
    }

    private function loadOrder()
    {
        // load
        foreach (new DirectoryIterator($this->tmpDir) as $file) {
            $fileName = $file->getFilename();
            if (substr($fileName, 0, 5) === 'order') {
                $resourceFile = "{$this->tmpDir}/{$fileName}";
                $order = json_decode(file_get_contents($resourceFile), true);
                $id = $order['id'];
                $order['_links']['self'] =  [Link::HREF =>"app://self/restbucks/order?id={$id}"];
                $order['_links']['edit'] =  [Link::HREF =>"app://self/restbucks/order?id={$id}"];
                $this->body['order'][] = $order;
            }
        }
    }
}
