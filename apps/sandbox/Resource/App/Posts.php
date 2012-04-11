<?php
namespace sandbox\Resource\App;

use BEAR\Framework\Annotation\Db;
use BEAR\Framework\Interceptor\DbSetter;
use BEAR\Framework\Link\View;
use BEAR\Resource\AbstractObject as ResourceObject;
use Doctrine\DBAL\Connection;
use PDO;

/**
 * Posts
 *
 * @Db
 */
class Posts extends ResourceObject implements DbSetter
{
    /**
     * Table
     *
     * @var string
     */
    private $table = 'posts';

    /**
     * DB
     *
     * @var Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Set DB
     *
     * @param Connection $db
     *
     * @return void
     */
    public function setDb(Connection $db = null)
    {
        $this->db = $db;
    }

    /**
     * Get
     *
     * @return array
     */
    public function onGet()
    {
        $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
        $stmt = $this->db->query($sql);
        $this->body = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this;
    }

    /**
     * Post
     *
     * @param string   $title
     * @param string   $body
     * @param DateTime $created
     * @param DateTime $modified
     *
     * @return \sandbox\Resource\App\Posts
     */
    public function onPost($title, $body, $created = null, $modified = null)
    {
        $this->db->insert($this->table, ['title' => $title, 'body' => $body]);
        $this->code = 204;
        return $this;
    }
}
