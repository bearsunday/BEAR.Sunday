<script src="/app/js/modal.js"></script>
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
		<td><a href="{href rel="page_item" data=$post}">{$post.title|escape}</a></td>
		<td>{$post.body|truncate:60|escape}</td>
		<td>{$post.created}</td>
		<td><a title="Edit post" class="btn"
			href="{href rel="page_edit" data=$post}"><span class="icon-edit"></span></a>
			<a title="Delete post" class="btn" href="#"
			onclick="return MyDialogs.loadConfirmationModal('my_dialog', '{href rel="page_delete" data=$post}', 'Are you sure ?', 'The entry will be deleted permanently.');"><span
				class="icon-trash"></span></a></td>
	</tr>
	{/foreach}
</table>
