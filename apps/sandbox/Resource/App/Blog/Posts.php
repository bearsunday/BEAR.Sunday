<?php
namespace sandbox\Resource\App\Blog;

use BEAR\Framework\Annotation\Db;
use BEAR\Framework\Interceptor\DbSetter;
use BEAR\Framework\Annotation\Time;
use BEAR\Framework\Annotation\Transactional;
use BEAR\Framework\Annotation\Cache;
use BEAR\Resource\AbstractObject as ResourceObject;
use Doctrine\DBAL\Connection;
use PDO;
use Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * Posts
 *
 * @Db
 */
class Posts extends ResourceObject implements DbSetter
{
    /**
     * Time
     *
     * @var string
     */
    public $time;

    /**
     * Table
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * DB
     *
     * @var Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * Set DB
     *
     * @param Connection $db
     *
     * @return void
     */
    public function setDb(DriverConnection $db = null)
    {
        $this->db = $db;
    }

    /**
     * Get
     *
     * @Cache(100)
     *
     * @return array
     */
    public function onGet($id = null)
    {
        $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
        if (is_null($id)) {
            $stmt = $this->db->query($sql);
            $this->body = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql .= " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->execute();
            $this->body = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $this;
    }

    /**
     * Post
     *
     * @param string   $title
     * @param string   $body
     *
     * @return \sandbox\Resource\App\Posts
     *
     * @Time
     * @Transactional
     */
    public function onPost($title, $body)
    {
        $values = [
            'title' => $title,
            'body' => $body,
            'created' => $this->time
        ];
        $this->db->insert($this->table, $values);
        $this->code = 204;
        return $this;
    }

    /**
     * Put
     *
     * @param int $id
     * @param string $title
     * @param string $body
     *
     * @Time
     */
    public function onPut($id, $title, $body)
    {
        $values = [
            'title' => $title,
            'body' => $body,
            'created' => $this->time
        ];
        $this->db->update($this->table, $values, array('id' => $id));
        $this->code = 204;
        return $this;
    }

    /**
     * Delete
     *
     * @param int $id
     */
    public function onDelete($id)
    {
        $this->db->delete($this->table, array('id' => $id));
        $this->code = 204;
        return $this;
    }
}
