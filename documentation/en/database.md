---
layout: default
title: BEAR.Sunday | Database
category: Others
---
# Database 

BEAR.Sunday does not have it's own DB / ORM library but has all the underpinnings needed for you to be able to use a number of DB setups.

Choose from `Doctrine DBAL, ORM`,`ZF2\Db`, `PDO` etc as a library and inject them into the resource object or
intercept it and use a database.

In the _sandbox application Doctrine.DBAL is used_.

## @Db 

In the sandbox application, the object injector binds DB object classes annotated with `@Db` to `on` methods.
The DB object is injected at the same time that the class annotated with @Db has its `onGet` method requested.

The db connection and utilization concerns are separated, the utilized code knows nothing about the connection. 

Code for using a database.
```
/**
 * @Db
 */
class Posts extends ResourceObject implements DbSetterInterface
{
    /**
     * @var Doctrine\DBAL\Connection
     */
    protected $db;

    public function setDb(DriverConnection $db = null)
    {
        $this->db = $db;
    }

    public function onGet($id)
    {
        $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
        $this->body = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $this;
    }
}
```
The DB injector holds dependencies on @Named("master_db") and @Named("slave_db") for master and slave db connection information. 
In the sandbox application, in ConstantModule their constant dependencies are installed. 

### master/slave Auto selection 

The `DbInjector` looks at the request method and chooses the DB connection (GET=slave), connects and sets the DB object.

### Partitioning 
When it is necessary to have the DB partitioned according to ID, you can prepare and bind a separate injector to describe the choice logic.

## @!DbPager 

When this DB injector has a method annotated with `@DbPager`, 
the query is converted to a DB pager query, the pager meta information in stored in a header with the *pager* key.

|| maxPerPage || Maximum Items per Page ||
|| current || Current Page Number ||
|| total || Total Number of Pages ||
|| hasNext || Next Existence ||
|| hasPrevious || Previous Existence ||
|| html || Pager Link(twitter/bootstrap format) ||

For example to specify pagination the template assigned to `$posts` looks like the following. 

```
{$posts->headers.pager.html}
```
_※smarty template engine example_

## @Transactional 
Methods annotated with `@Transactional` are bound to the transaction interceptor.
```
    /**
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

        return $this;
    }
```

### @Time 
### @!CacheUpdate 
The method uses the current time ($this->time) bound by `@Time`, 
using a transaction performs an insert query.
Not only is this run when committing the cache updater bound with `@CacheUpdate` runs, clearing the old cache replacing it with the new.

## Hint 
 * As a dependency for SQL and table names lets try using @Inject.
 * Validations are not run inside the method, they are bound as an interceptor. They may be able to be combined with form validation.
　* How would it be for example to use analysis data run the query again and have the interceptor just run `execute`.