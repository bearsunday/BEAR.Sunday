<?php

namespace demoWorld\ResourceObject\User;

use BEAR\Resource\Object as ResourceObject,
BEAR\Resource\AbstractObject;
use Ray\Di\ProviderInterface;

/**
 * User
 *
 * @Aspect
 */
class Pdo extends AbstractObject
{
    /**
     * Db
     *
     * @var PDO
     */
    private $db;

    /**
     * Constructor
     *
     * @param array $message
     *
     * @Inject
     * @Named("dbProvider=user_db")
     */
    public function __construct(ProviderInterface $dbProvider)
    {
        $this->dbProvider = $dbProvider;
    }

    public function __wakeup()
    {
        $this->db = $this->dbProvider->get();
    }
    
    /**
     * @Transactional
     */
    public function onPost($name, $age)
    {
        $this->code = 201;
        $sth = $this->db->prepare("INSERT INTO User (Name, Age) VALUES (:name, :age)");
        $sth->execute([':name' => $name, ':age' => $age]);
        return $this;
    }

    /**
     * Get
     *
     * @return string
     */
    public function onGet($id)
    {
        $sth = $this->db->query("SELECT name, age FROM User");
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}
