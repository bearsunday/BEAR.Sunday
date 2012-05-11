<?php
namespace sandbox\Resource\App;

use BEAR\Framework\Annotation\Db;
use BEAR\Framework\Interceptor\DbSetter;
use BEAR\Framework\Link\View;
use BEAR\Framework\Annotation\Time;
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
     *
     * @return \sandbox\Resource\App\Posts
     * 
     * @Time
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
    
    public function onDelete($id)
    {
        $this->db->delete($this->table, array('id' => $id));
        $this->code = 204;
        return $this;
    }
}
