    <!-- set up the modal to start hidden and fade in and out -->

<table class="table table-bordered table-striped">
    <tr>
        <th class="span1">Id</th>
        <th>Title</th>
        <th>Body</th>
        <th>CreatedAt</th>
        <th>Action</th>
    </tr>
    {foreach from=$resource->body item=post}
    <tr>
        <td>{$post.id}</td>
        <td><a href="#">{$post.title}</a></td>
        <td>{$post.body}</td>
        <td>{$post.created}</td>
        <td><a class="btn" href="#" onclick="return MyDialogs.loadConfirmationModal('my_dialog', '/blog/posts?_method=delete&id={$post.id}', 'Are you sure ?', 'The entry will be deleted permanently.');">Delete</a></td>
    </tr>
    {/foreach}    
</table>    