    <!-- set up the modal to start hidden and fade in and out -->

<table class="table table-bordered table-striped">
    <tr>
        <th class="span1">Id</th>
        <th>Title</th>
        <th>Body</th>
        <th>CreatedAt</th>
        <th></th>
    </tr>
    {foreach from=$resource->body item=post}
    <tr>
        <td>{$post.id}</td>
        <td><a href="posts/post?id={$post.id}">{$post.title}</a></td>
        <td>{$post.body|truncate:60}</td>
        <td>{$post.created}</td>
        <td>
        <a title="Edit post" class="btn" href="/blog/posts/edit?id={$post.id}"><span class="icon-edit"></span></a>
        <a title="Delete post" class="btn" href="#" onclick="return MyDialogs.loadConfirmationModal('my_dialog', '/blog/posts?_method=delete&id={$post.id}', 'Are you sure ?', 'The entry will be deleted permanently.');"><span class="icon-trash"></span></a>
        </td>
    </tr>
    {/foreach}    
</table>    