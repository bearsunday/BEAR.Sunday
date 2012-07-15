<?php
$app = require dirname(dirname(__DIR__)) . '/scripts/instance.php';
$message = $app->resource->get->uri('app://self/first/greeting')->withQuery(['name' => 'BEAR'])->eager->request()->body;
?>
<html>
    <body><?php echo $message;?></body>
</html>
