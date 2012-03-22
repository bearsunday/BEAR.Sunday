<table>
    <tr>
        <td>Id</td>
        <td>Title</td>
        <td>CreatedAt</td>
    </tr>
    <!-- ここから、posts配列をループして、投稿記事の情報を表示 -->
    {foreach from=$resource->body item=post}
    <tr>
        <td>{$post.id}</td>
        <td><a href="item.php/?id={$post.id}">{$post.title}</a></td>
        <td>{$post.created}|date('Y/m/d H:i')</td>
    </tr>
    {/foreach}
</table>