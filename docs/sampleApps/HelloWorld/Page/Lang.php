<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\ResourceObject\Page as PageResource;

class HelloWorld extends PageResource
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
     *
     * @Inject
     * @Named("lang=user_lang");
     */
    public function onGet($lang)
    {
        $params = $this->params->get()->setUri('ro://self/Greetings')->setParams(['lang' => $lang]);
        $this->resource->read($params)->set('greetings');
    }
}
