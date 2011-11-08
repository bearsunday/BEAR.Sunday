<?php

namespace BEAR\App\sample;

use BEAR\Resource\Object as Ro;

/**
 * Resource Link DSL sample page
 */
class User extends Ro
{    
    /**
     * @Inject
     */
    public function __construct(
        Query $query
    ){
        $this->query = $query;
    }
    
    /**
     * @param int $userId
     * 
     * @Auth("role=member")
     * @Validate
     * @Cache("time=30")
     * @Template
     * @Log
     */
    public function onGet($userId)
    {
        $this['user'] = $this->query->select($sql1);
        $this['frined'] = $this->query->select($sql2);
        return $result;
    }
}