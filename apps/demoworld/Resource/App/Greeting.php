<?php

namespace demoworld\Resource\App;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Greeting extends AbstractObject
{
    /**
     * Greeting message
     *
     * @var array
     */
    private $messsage;

    /**
     * Constructor
     *
     * @param array $message
     *
     * @Inject
     * @Named("message=GreetingMessage")
     */
    public function __construct(array $message)
    {
        $this->message = $message;
    }

    /**
     * Get
     *
     * @param string $lang
     * @return string
     *
     */
    public function onGet($lang)
    {
        $greeting = $this->message[$lang];
        return $greeting;
    }
}
