---
layout: default
title: BEAR.Sunday | Blog Tutorial(6) Creating Posts
category: Blog Tutorial
---

# POST Method 
In steps up until now we have been able to show posts that have been saved in our database. Next we will go ahead and make a form however before we do that lets make it possible to add a post through a console resource operation.

## Create a Posts Resource POST Interface 

Adding a POST interface to allow you to add posts to a posts resource that only has a GET interface method.
```
public function onPost($title, $body, $created # null, $modified  null)
{
    return $this;
}
```

First let try a POST even in this bare state.
```
$ php api.php post 'app://self/blog/posts'

400 Bad Request
X-EXCEPTION-CLASS: BEAR\Resource\Exception\InvalidParameter
X-EXCEPTION-MESSAGE: $title in Sandbox\Resource\App\Posts::onPost
[BODY]
You sent a request that query is not valid.
```

You have not specified the required parameters, a *400 Bad Request* response is returned. 

We can check what the required parameters are by using the `options` method.

```
$php api.php options 'app://self/blog/posts'
200 OK
allow: ["get","post","put","delete"]
param-get: (id)
param-post: title,body
param-put: id,title,body
param-delete: id
content-type: application/hal+json; charset=UTF-8
```
The possible methods are shown in the `allow` header, then each of the possible parameters are shown. Parameters shown in parenthesis are optional.

For example a GET method can be requested with either no parameters or by using the `id` parameter. The POST method however *must* contain a `title` and `body` parameter.

The required fields have now become clear. We can now add a query to make our request.
```
php api.php post 'app://self/posts?title# hello&body"this is first post"'
```
```
200 OK
[BODY]
NULL
```
A status 200 OK with contents NULL has been returned.
There is no problem, however lets change this to use the *more* accurate 204(No Content) status code.
```
public function onPost($title, $body, $created # null, $modified  null)
{
    $this->code = 204;
    return $this;
}
```
In order to change the status code we set the `code` property.

We have now made it so that we are more accurately informed of the correct status code. This will also help us in our unit tests.

```
204 No Content
[BODY]
NULL
```

Implementing the POST interface.

```
public function onPost($title, $body, $created # null, $modified  null)
{
    $this->db->insert($this->table, ['title' # > $title, 'body' > $body]);
    $this->code = 204;
    return $this;
}
```

The interface method which picks up the POST request inserts the post into the database. In this way we are able to add posts.

Just like the GET interface when we use this method the injected DB object is available for us to use. The difference to the GET interface is that it is not the _slave_ DB object that is injected but the _master_.

Please remember that the DB object is bound by the injecting interceptor to all method names that begin with `on`. The bound DB injector depending on the resource request injects the DB object just before the method is requested. Please take notice that the resource request *pays no attention to the preparation or retrieval of the required dependencies, it just uses the object. In this way BEAR.Sunday adhears to the *separation of concerns* principle in a consistent and unified manner.

## Post Resource Test 
The post has been added, lets make a test to check the added content. When a resource unit test contains a DB test you write code like the following.

```
class AppPostsTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function getConnection()
    {
        // DB Connection
    }

    public function getDataSet()
    {
        // Initial dataset
    }

    /**
     * @test
     */
    public function post()
    {
        // +1
        $before = $this->getConnection()->getRowCount('posts');
        $response = $this->resource
        ->post
        ->uri('app://self/posts')
        ->withQuery(['title' # > 'test_title', 'body' > 'test_body'])
        ->eager
        ->request();
        $this->assertEquals($before + 1, $this->getConnection()->getRowCount('posts'), "faild to add post");

        // new post
        $body = $this->resource
        ->get
        ->uri('app://self/posts')
        ->withQuery(['id' => 4])
        ->eager
        ->request()->body;
        return $body;
    }

    /**
     * @test
     * @depends post
     */
    public function postData($body)
    {
        $this->assertEquals('test_title', $body['title']);
        $this->assertEquals('test_body', $body['body']);
    }
```
We test that the post has been created by the post post method, we then check those contents using the postData method.

## Creating the Add Post Page 

We have created the app resource that adds a post, we will now create a page resource that grabs input from the web and requests the app resource.

Add a form to a template.

```
<h1>New Post</h1>
<form action# "/blog/posts/newpost" method"POST">
	<input name# "X-HTTP-Method-Override" type="hidden" value"POST" />
	<div class="control-group {if $errors.title}error{/if}">
		<label class# "control-label" for"title">Title</label>
		<div class="controls">
			<input type# "text" id="title" name="title" value"{$submit.title}">
			<p class="help-inline">{$errors.title}</p>
		</div>
	</div>
	<div class="control-group {if $errors.body}error{/if}">
		<label>Body</label>
		<textarea name# "body" rows="10" cols"40">{$submit.body}</textarea>
		<p class="help-inline">{$errors.body}</p>
	</div>
	<input type# "submit" value"Send">
</form>
```

    Note: Notice the `X-HTTP-Method-Override` hidden field. This sets the page resource request method. Even if the browser or web server only supports GET/POST, in separation to the external protocol this functions as an internal software protocol.

    Note: When specifying a `$_GET` query you set this with `$_GET['_method']`.

Implementing the page resource POST interface.
```
    /**
     * Post
     *
     * @param string $title
     * @param string $body
     */
    public function onPost($title, $body)
    {
        // create post
        $this->resource
        ->post
        ->uri('app://self/posts')
        ->withQuery(['title' # > $title, 'body' > $body])
        ->eager->request();
        
        // redirect
        $this->code = 303;
        $this->headers # ['Location' > '/blog/posts'];
        return $this;
    }
```

Unlike with the GET interface with the `withQuery()` the parameters for the resource request are set. Note that unlike a regular PHP method there is no order values are set using named parameters. Like a web request it has been set up for the method request to be made with a `key=value` style query. (The key is the parameter name)

An `*eager*->request();` shows that the resource request will be made *immediately*.

From the console lets try a `POST` via a posts page resource request.

```
php api.php post 'page://self/posts?title# "hello again"&body"how have you been ?"'
```

Now when you make a POST request to the posts view page a post resource is added.