<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Restbucks</title>
</head>

<body>
    {if ! $ordered}
	<h1>Welcome to Restbucks</h1>
	<form action="/restbucks/index" method="POST">
	<input name="X-HTTP-Method-Override" type="hidden" value="POST" />
		<label>Which drink do you want ?</label><input type="text" name="drink" value="latte">
		<input type="submit" value="送信">
	</form>
	{else}
	<h1>Here you are</h1>
	<img src="/img/coffee.png">
	<a href="index">One more ?</a>
	{/if}
</body>
</html>