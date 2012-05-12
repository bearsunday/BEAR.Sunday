<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>BEAR.Sunday Blog</title>
<link href="/assets/css/bootstrap.css" rel="stylesheet">
<link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap-modal.js"></script>
<script src="/app/js/modal.js"></script>
</script>
</head>
<body>
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span></li>
			<li><a href="/blog/posts">Blog</a> <span class="divider">/</span></li>
			<li class="active">Post</li>
		</ul>

		<h2>{$post.title}</h2>
		<span class="label label-info">{$post.created}</span>
		<div style="padding:10px"></div>
		<p>{$post.body}</p>
	</div>
</body>
</html>