<?php

namespace demoworld\Resource\App\User;

use BEAR\Resource\Object as ResourceObject,
BEAR\Resource\AbstractObject;
use Ray\Di\ProviderInterface as Provide;
use BEAR\Framework\Module\AbstractSingletonProvider;

/**
 * User resource using native PDO
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
     * @param Provide $dbProvider
     *
     * @Inject
     * @Named("dbProvider=pdo")
     */
    public function __construct(Provide $dbProvider)
    {
        $this->dbProvider = $dbProvider;
    }

    /**
     * Init
     */
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
    public function onGet()
    {
        $sth = $this->db->query("SELECT name, age FROM User");
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}
