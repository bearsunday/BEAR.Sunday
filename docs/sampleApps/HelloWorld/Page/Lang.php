<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\Resource\ResourceObject\Resource;
use BEAR\Resource\ResourceObject\Page;
use BEAR\Resource\Cleint;

class HelloWorld extends Page
{
    /**
     * Constructor
     *
     * @Inject
	 * @Named("greeting=greeting")
     */
    public function __construct(
		Client $client,
		Resource $greeting
	) {
        $this->client = $client;
        $this->greeting = $greeting;
    }

    /**
     * @Get
     */
    public function onGet($lang)
    {
       $this->greeting->setQuery(['lang' => $lang]);
        $this->client->get($this->greeting)->set('greetings');
    }
}
