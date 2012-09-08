<?php
namespace sandbox\Resource\App\Blog;

use BEAR\Framework\Annotation\Db;
use BEAR\Framework\Interceptor\DbSetterInterface;
use BEAR\Framework\Annotation\Time;
use BEAR\Framework\Annotation\Transactional;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Annotation\CacheUpdate;
use BEAR\Resource\AbstractObject as ResourceObject;
use Doctrine\DBAL\Connection;
use PDO;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use BEAR\Framework\Resource\Link;

/**
 * Posts
 *
 * @Db
 */
class Posts extends ResourceObject implements DbSetterInterface
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
     * Resource links
     *
     * @var array
     */
    public $links = [
        'page_post' => [Link::HREF => 'page://self/blog/posts/post'],
        'page_item' => [Link::HREF => 'page://self/blog/posts/post{?id}', Link::TEMPLATED => true],
        'page_edit' => [Link::HREF => 'page://self/blog/posts/edit{?id}', Link::TEMPLATED => true],
        'page_delete' => [Link::HREF => 'page://self/blog/posts?_method=delete{&id}', Link::TEMPLATED => true]
    ];

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
     * @param string $title
     * @param string $body
     *
     * @return \sandbox\Resource\App\Posts
     *
     * @Time
     * @Transactional
     * @CacheUpdate
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
        $this->links['new_post'] = 'app://self/posts/post?id=300';
        $this->links['page_new_post'] = 'page://self/posts/post?id=300';

        return $this;
    }

    /**
     * Put
     *
     * @param int    $id
     * @param string $title
     * @param string $body
     *
     * @Time
     * @CacheUpdate
     */
    public function onPut($id, $title, $body)
    {
        $values = [
            'title' => $title,
            'body' => $body,
            'created' => $this->time
        ];
        $this->db->update($this->table, $values, ['id' => $id]);
        $this->code = 204;

        return $this;
    }

    /**
     * Delete
     *
     * @CacheUpdate
     *
     * @param int $id
     */
    public function onDelete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
        $this->code = 204;

        return $this;
    }
}
