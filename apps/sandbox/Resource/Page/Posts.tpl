<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>BEAR.Sunday blog</title>
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">

    <h1>Posts</h1>
    <p>{$posts->body}</p>

    <h1>Submit</h1>
    <form action="/posts">
        <input name="X-HTTP-Method-Override" type="hidden" value="POST" />
        <p><label>タイトル</label><input type="text" name="title"></p>
        <p><label>本文</label><textarea name="body" rows="10" cols="40"></textarea></p>
        <input type="submit" value="送信">
    </form>
    </div>
  </body>
</html>