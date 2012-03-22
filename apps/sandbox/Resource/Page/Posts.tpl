<html>
    <body>
    <h1>Posts</h1>
    {$posts->body}

    <h1>Submit</h1>
    <form action="/posts">
        <input name="X-HTTP-Method-Override" type="hidden" value="POST" />
        <p><label>タイトル</label><br><input type="text" name="title"></p>
        <p><label>本文</label><br><textarea name="body" rows="10" cols="40"></textarea></p>
        <input type="submit" value="送信">
    </form>
    </body>
</html>
