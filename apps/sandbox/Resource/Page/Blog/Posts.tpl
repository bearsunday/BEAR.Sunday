{extends file="layout/Blog.tpl"}
{block name=title}Posts{/block}
{block name=page}

<ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li class="active">Blog</li>
</ul>
<div align="right">
	<a href="posts/pager" class="btn btn-success btn-mini">Pagination</a>
</div>

<h1>Posts</h1>
<p>{$posts}</p>
<a href="posts/newpost" class="btn btn-primary btn-large">New Post</a>
{/block}
{else}
submit
{/if}
