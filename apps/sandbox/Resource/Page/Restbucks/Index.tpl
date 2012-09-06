<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="/assets/css/bootstrap.css" rel="stylesheet">
</style><title>Restbucks</title>
</head>

<body>
<div class="container">
    {if ! $ordered}
	<h1>Welcome to Restbucks</h1>

	<form action="/restbucks/index" method="POST">
	    <legend>Order here</legend>
	    <input name="X-HTTP-Method-Override" type="hidden" value="POST" />
		<label>Which drink do you want ?</label>
		<input type="text" name="drink" value="latte">
		<div></div>
		<input type="submit" value="Order">
	</form>
	<p>* RESTBucks is a RESTful coffee shop, You can see more at <a href="http://www.infoq.com/articles/webber-rest-workflow">InfoQ:How to GET a Cup of Coffee</a>, <a href="http://www.infoq.com/jp/articles/webber-rest-workflow">InfoQ:1杯のコーヒーを得る方法</a></p>
	<p>* Output format is HAL, <a href="http://stateless.co/hal_specification.html">Hypertext Application Language</a></p>
	{else}
		{foreach from=$logs item=log}
		<div class="well">
	    <code>{$log.request}</code><br><br>
	    <span class="label label-success">{$log.code}</span><br>
	    <pre>{$log.body}</pre>
	    </div>
	{/foreach}
	<h2>Here you are !</h2>
	<img src="/img/coffee.png">
	<a href="index">One more ?</a> or <a href="/">No, Thanks.</a>

	{/if}
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	</div>
</body>
</html>