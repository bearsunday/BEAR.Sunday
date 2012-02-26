<?php
namespace demoworld\Resource\Page\App;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * Hello World using resource
 */
class Hello extends Page
{
    use PhpView;

    /**
     * @var ResourceObject
     */
    protected $greeting;

    /**
     * Resource
     *
     * @var Client
     */
    protected $resource;

    /**
     * @param Resource $resource Resource Client
     *
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
        $this->helloPpage = $resource->newInstance('page://helloworld/hello');
    }

    /**
     * @param string $lang laungauage
     *
     * @return ResourceObject
     */
    public function onGet()
    {
        $this['greeting'] = $this->resource->get->object($this->helloPpage)->withQuery(['name' => 'another app'])->eager->request();
        return $this;
    }
}
