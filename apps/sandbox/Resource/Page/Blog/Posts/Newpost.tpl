{extends file="layout/Blog.tpl"}
{block name=title}New Post{/block}
{block name=page}
<ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/blog/posts">Blog</a> <span class="divider">/</span></li>
	<li class="active">New Post</li>
</ul>

<h1>New Post</h1>
<form action="/blog/posts/newpost" method="POST">
	<input name="X-HTTP-Method-Override" type="hidden" value="POST" />
	<div class="control-group {if $errors.title}error{/if}">
		<label class="control-label" for="title">Title</label>
		<div class="controls">
			<input type="text" id="title" name="title" value="{$submit.title}">
			<p class="help-inline">{$errors.title}</p>
		</div>
	</div>
	<div class="control-group {if $errors.body}error{/if}">
		<label>Body</label>
		<textarea name="body" rows="10" cols="40">{$submit.body}</textarea>
		<p class="help-inline">{$errors.body}</p>
	</div>
	<input type="submit" value="‘—M">
</form>
{/block}