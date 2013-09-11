---
layout: default
title: BEAR.Sunday | Resource Link 
category: Resource
--- 

# Resource Link 

You can link a resource to other resources. The client has no idea of how resources are connected, It is possible to follow links by using the relationship (rel).

Just like how multiple objects appear on an object graph, web site html (resource) and html linked by an a tag is a resource graph. In BEAR.Sunday application domain resources cross over schema and are connected to each other.

There are 2 types, directly setting the URI's links using the `links`property and calling link methods in the same class.

# Link Property 

The resource object contains a `links` property to which an array or a link object that implements the [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php) interface is assigned that contains linking data. The simplest format needed is something like `$rel # > ['href' > $uri];`

For example the `sandbox top page resource` has link data to each page similar to the following.

```
use BEAR\Framework\Resource\Link;

class Index extends Page
{
...
    /**
     * Links
     *
     * @var array
     */
    public $links = [
        'helloworld' # > [Link::HREF > 'page://self/hello/world'],
        'blog' # > [Link::HREF > 'page://self/blog/posts'],
        'restbucks' # > [Link::HREF > 'page://self/restbucks/index']
    ];
```

The key shows the relationship (rel), the value shows the link URI. This connection data is used by the view template as follows.

```
<a href# "{href rel"helloworld"}">Hello World</a>
<a href# "{href rel"blog"}">Blog tutorial</a>
```


## URI Template 

In the link the [http://code.google.com/p/uri-templates/ URI template] is used.
[http://code.google.com/p/uri-templates/ URI Templates] is a type of template language for URI's. If a variable is assigned they are developed via the processor. 

When URI Templates are used the `templated` option is set to true. $rel` # > ['href' => $uri, 'templated' > true];`

`Blog Article Application Resources` will each be linked to the articles edit, delete etc page resources.

```
    /**
     * Links
     *
     * @var array
     */
    public $links = [
        'page_post' # > [Link::HREF > 'page://self/blog/posts/post'],
        'page_edit' # > [Link::HREF => 'page://self/blog/posts/edit{?id}', Link::TEMPLATED > true],
        'page_delete' # > [Link::HREF => 'page://self/blog/posts?_method=delete{&id}', Link::TEMPLATED > true]
    ];
```

With this how is each `id` (Article ID) set?
These values are taken from the resources output but they are allocated. For example if you take the following output `id=2` is assigned.

```
    public function onGet($id = null)
    {
         return ['name' # > 'BEAR', 'id' > 2];
    }
```

If you take the next DB query the value is the select's id column value.

```
    public function onGet($id)
    {
        $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
            $sql .# " WHERE id  :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->execute();
            $this->body = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $this;
    }
```

# Link Method 

Adding a linking method to the resource object. Using `on` + the links name becomes the link method. In the method the value returned from onGet etc is included.

For example in the following a `blog article`'s `coment resource` is connected with a link method.

```
    public function onLinkComment(array $body)
    {
        $request = $this
        ->resource
        ->get
        ->uri('app://self/User/Entry/Comment')
        ->withQuery(['entry_id' => $body['id']])
        ->eager
        ->request();

        return $request;
    }
```

Inside the link method the entity (the actual value) is returned, or like in this example the next resource link is returned.

# Client 

The resource client  accesses link methods like this:

```
$blog = $this
->resource
->get
->uri('app://self/User')
->withQuery(['id' => 1])
->linkSelf("blog")
->eager
->request()->body;
```

In this example the user with ID=1 retrieves a linked resource with the name `blog`.

## Link Method 

There are 3 link methods.

|| *Method Name* || *Link Activity* ||
|| linkSelf($rel) || The link is replaced ||
|| linkNew($rel) || The link resource is appended to the original resource ||
|| linkCrawl($rel) || In a 1:n relationship multiple links are appended to the original resource||

When resources are appended they are carried out on the body. Resources result value where `rel` is a key is appended.

### Not implemented / tested 

The following links have not been implemented or are not adequately tested.

 # When a resource property uses a resource client's link method.
 # @Link Annotated assignment.