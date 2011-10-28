<?php

namespace BEAR\Di\Modules;

use BEAR\Di\AbstractModule;

class LangModule extends AbstractModule
{
	/**
	 * @Inject
	 */
	public function __construct(ResourceBuilder $resourceBuilder)
	{
		$this->resouceBuilder = $resourceBuilder;
	}
	
    protected function configure()
    {
        $this->bind()->annotatedWith('user_lang')->toInstance('en');
		$this->bind('Client')->to('BEAR\Resource\ResourceClient' );
		$this->bind('Resource')->annotatedWith('greeting')->to(new $this->resourceBuidler->newInstance('app://user'));
    }
}