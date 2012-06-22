{extends file="layout/Blog.tpl"}
{block name=title}Pagination{/block}
{block name=page}
<ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span> <a
		href="/blog/posts">Blog</a> <span class="divider">/</span></li>
	<li class="active">Pager</li>
</ul>

<h1>Posts</h1>
<p>{$posts}</p>
<div align="center">{$posts->headers.pager.html}</div>
<a href="/blog/posts/newpost" class="btn btn-primary btn-large">New
	Post</a>
{/block}