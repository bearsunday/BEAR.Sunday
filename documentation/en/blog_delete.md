---
layout: default
title: BEAR.Sunday | Blog Tutorial(8) Deleting Posts
category: Blog Tutorial
---
# DELETE Method 

## Deleting a Post page 

So that you can delete a post that has is identified with an `id` from our posts page, we will create an `onDelete()` method in the posts page resource, this will respond to a DELETE request.

```
    /**
     * Delte
     * 
     * @param int $id
     */
    public function onDelete($id)
    {
        // delete
        $this->resource
        ->delete
        ->uri('app://self/posts')
        ->withQuery(['id' => $id])
        ->eager
        ->request();
        
        // message
        $this['message'] = 'Entry deleted.';
        return $this->onGet();
    }
```

As a page resource receives a `DELETE` request from a web browser it in the same way makes a `DELETE` request to the posts resource.s

This link to the posts page resource will be available on the posts resource template. Using Javascript show a confirmation dialog, then so that the page request is made as a `DELETE` method use the `_method` query.

  Note: When posting using the `X-HTTP-Method-Override` hidden element or in the GET query a `_method` parameter is an _HTTP Method Override_ method of supporting PUT/DELETE when your browser or when your server environment prevents you from fully using HTTP verbs.

## Create a Posts Resource DELETE interface 

Receive a request post from a posts page and through accessing the DB delete the post. 

```
    public function onDelete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
        $this->code = 204;
        return $this;
    }
```

  Note: Like the GET request interface the `$this->db` is automatically set by the injector. What is different to the GET request is that it used the master DB connection.


## Checking this with through the Command Line
Lets try it out. We have set it up with a 204 status code so it should look like this.

```
$ php api.php delete app://self/posts?id=1
204 No Content
[BODY]
```

## Unit Test 

If we access with DELETE the records should be reduced by 1. The test will look something like this.
```
    /**
     * @test
     */
    public function delete()
    {
        // dec 1
        $before = $this->getConnection()->getRowCount('posts');
        $response = $this->resource
        ->delete
        ->uri('app://self/posts')
        ->withQuery(['id' => 1])
        ->eager
        ->request();
        $this->assertEquals($before - 1, $this->getConnection()->getRowCount('posts'), "faild to delete post");
    }
```

## Javascript Confirmation Dialogue 

In order to add a confirmation to a delete action the we use the JS library that is included with the sandbox application.

```
<a title# "Delete post" class="btn" href="#" onclick="return MyDialogs.loadConfirmationModal('my_dialog', '/blog/posts?_method=delete&id={$post.id}', 'Are you sure ?', 'The entry will be deleted permanently.');"><span class"icon-trash"></span></a>
```