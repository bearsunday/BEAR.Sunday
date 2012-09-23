<?php
/**
 * App resource
 *
 * @package    sandbox
 * @subpackage resource
 */
namespace sandbox\Resource\Page\First;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use Ray\Di\Di\Inject;

/**
 * Greeting page
 */
class Greeting extends Page
{
    use ResourceInject;

    public $body = [
        'greeting' => 'Hello.'
    ];

    /**
     * Get
     *
     * @param string $name
     */
    public function onGet($name = 'anonymous')
    {
        $this['greeting'] = $this
        ->resource
        ->get
        ->uri('app://self/first/greeting')
        ->withQuery(['name' => $name])
        ->request();
        echo $this['greeting']->toUri();

        return $this;
    }
}
