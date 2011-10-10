<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\ResourceObject\Page as PageResource;

class Resource extends PageResource
{
    /**
     * Constructor
     *
     * @param Resource $resource
     * @Inject
     */
    public function __construct(Resource $resource, Provider $params)
    {
        $this->resource = $resource;
        $this->params = $params;
    }

    /**
     * Get
     *
     * @return void
     */
    public function onGet()
    {
        $params = $this->params->get()->setUri('ro://self/HelloWorld');
        $this->resource->get($params)->set('message');
    }
}
