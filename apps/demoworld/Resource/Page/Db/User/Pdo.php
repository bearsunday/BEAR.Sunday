<?php
namespace demoworld\Resource\Page\Db\User;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Php as PhpView;

class Pdo extends Page
{
    use PhpView;

    /**
     * @var ResourceObject
     */
    protected $user;

    /**
     * Resource
     *
     * @var Client
     */
    protected $resource;

    /**
     * Constructor
     *
     * @param Resource $resource Resource Client
     *
     * @Inject
     */
    public function __construct(Resource $resource){
        $this->resource = $resource;
        $this->user = $resource->newInstance('app://self/user/pdo');
    }

    /**
     * @param int $id
     *
     * @return ResourceObject
     */
    public function onGet($id = 1)
    {
        $this['greeting'] = $this->resource->get->object($this->user)->withQuery(['id' => 1])->eager->request();
        return $this;
    }
}
