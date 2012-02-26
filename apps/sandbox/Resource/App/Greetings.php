<?php
namespace sandbox\Resource\App;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Greetings extends AbstractObject
{
    /**
     * Greeting message
     *
     * @var array
     */
    private $message = [
        'en' => 'Hello World',
        'ja' => 'Konichiwa Sekai',
        'es' => 'Hola Mundo'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get
     *
     * @param string $lang
     * @return string
     *
     */
    public function onGet($lang = 'en')
    {
        $greeting = $this->message[$lang];
        return $greeting;
    }
}
