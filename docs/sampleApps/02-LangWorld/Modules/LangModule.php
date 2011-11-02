<?php

namespace BEAR\Di\Modules;

use BEAR\Di\AbstractModule,
    BEAR\Resource\Resource;

class LangModule extends AbstractModule
{
    /**
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resouce = $resource;
    }
    
    protected function configure()
    {
        $this->bind('Resource')->to('BEAR\Resource\Resource');
        $this->bind('Ro')->annotatedWith('greeting')->toInstance($this->resource->newInstance('app://Greeting'));
    }
}