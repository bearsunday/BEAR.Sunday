{extends file="layout/Blog.tpl"}
{block name=title}New Post{/block}
{block name=page}
<ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/blog/posts">Blog</a> <span class="divider">/</span></li>
	<li class="active">New Post</li>
</ul>

{if $code == 200}
    {include file="Form/Post.tpl"}
{elseif $code == 201}
	<div class="alert alert-success">Successfully posted.</div>
	<ul>
	<li><a href="{href rel="page_new_post"}">See new post</a></li>
	<li><a href="{href rel="back"}">Back to list</a></li>
	</ul>
{else}
    <div class="alert alert-error">Something wrong.</div>
{/if}
{/block}