<?php
/**
namespace BEAR\App;

class MyPdo extends \PDO implements \Serializable
{
    public function __construct($dsn, $id, $password)
    {
            $this->dsn = $dsn;
            $this->id = $id;
            $this->password = $password;
    }
    
    public function serialize()
    {
        return serialize($this->dsn);
    }
    public function unserialize($data)
    {
        $dsn = unserialize($data);
        $this->__construct($dsn);
    }
}
*/