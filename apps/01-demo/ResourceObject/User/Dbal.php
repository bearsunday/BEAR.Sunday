<?php

namespace demoWorld\ResourceObject\User;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject;
use Ray\Di\ProviderInterface;
use Doctrine\DBAL\Connection;

/**
 * User using Doctirine DBAL (PDO)
 *
 * @Aspect
 */
class Dbal extends AbstractObject
{
    /**
     * Db
     *
     * @var Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param Connection $db
     *
     * @Inject
     * @Named("db=dbal")
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
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
    public function onGet()
    {
        $sth = $this->db->query("SELECT name, age FROM User");
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}
