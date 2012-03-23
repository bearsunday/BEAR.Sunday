<table class="table table-bordered table-striped">
    <tr>
        <th class="span1">Id</th>
        <th>Title</th>
        <th>Body</th>
        <th>CreatedAt</th>
    </tr>
    <!-- ここから、posts配列をループして、投稿記事の情報を表示 -->
    {foreach from=$resource->body item=post}
    <tr>
        <td>{$post.id}</td>
        <td><a href="/posts/{$post.id}">{$post.title}</a></td>
        <td>{$post.body}</td>
        <td>{$post.created}</td>
    </tr>
    {/foreach}
</table>