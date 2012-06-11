<?php
namespace sandbox\Resource\App\Blog\Posts;

use BEAR\Framework\Annotation\Db;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Interceptor\DbSetter;
use BEAR\Framework\Annotation\DbPager;
use PDO;

use sandbox\Resource\App\Blog\Posts;

/**
 * Posts
 *
 * @Db
 */
class Pager extends Posts implements DbSetter
{

    /**
     * Get
     *
     * @Cache
     * @DbPager(2)
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
}
