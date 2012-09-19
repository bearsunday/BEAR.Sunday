<?php
namespace sandbox\Resource\App\First;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class User extends AbstractObject
{
    public $link = [
        'friend' => ''
    ];

    private $users = [
        'id' => 1,
        'name' => 'BEAR'
    ];

    /**
     * Get
     *
     * @param string $id
     *
     * @return array
     */
    public function onGet($id)
    {
        return $this->users[$id];
    }
}
