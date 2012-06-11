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
			<li><a href="/">Home</a> <span class="divider">/</span> <a href="/blog/posts">Blog</a> <span class="divider">/</span></li>
			<li class="active">Pager</li>
		</ul>

		<h1>Posts</h1>
		<p>{$posts}</p>
		<div align="center">{$posts->headers.pager.html}</div>
		<a href="/blog/posts/newpost" class="btn btn-primary btn-large">New Post</a>
	</div>
</body>
</html>