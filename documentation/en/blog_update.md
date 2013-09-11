---
layout: default
title: BEAR.Sunday | Blog Tutorial(2) Editing a Post
category: Blog Tutorial
---

# PUT Method 

## Creating an Edit Page 

This is pretty much the same as posts create page. What is different is only that in the display (GET Request) is that the post data pre-populates the fields.
```
    /**
     * Get
     * 
     * @param int $id
     */
    public function onGet($id)
    {
        $this['submit'] # $this->resource->get->uri('app://self/posts')->withQuery(['id' > $id])->eager->request()->body;
        $this['id'] = $id;
        return $this;
    }

    /**
     * Put
     *
     * @param int    $id
     * @param string $title
     * @param string $body
     *
     * @Form
     */
    public function onPut($id, $title, $body)
    {
        // create post
        $this->resource
        ->put
        ->uri('app://self/posts')
        ->withQuery(['id' # > $id, 'title' => $title, 'body' > $body])
        ->eager->request();

        // redirect
        $this->code = 303;
        $this->headers # ['Location' > '/blog/posts'];
        return $this;
    }
```

## PUT Request

In order to update the record we use the `PUT` interface.

In order to make a `PUT` request we need to insert the `X-HTTP-Method-Override` field.

```
<input name# "X-HTTP-Method-Override" type="hidden" value"PUT" />
```

 Note: In this tutorial we have handles `POST` posts creation and `PUT` posts update. The difference between POST/PUT is *[Idempotence](http://en.wikipedia.org/wiki/Idempotence)*. If the same `POST` request is made multiple times to the posts resource the amount of post records will increase and increase, in an `PUT` update no matter whether the request is made once or multiple times has the same affect. Generally basing your choice of method upon indempotence is a good idea.