<?php
/**
 * Hello World (Pull)
 */
$app = require dirname(__DIR__) . '/scripts/instance.php';
$hello = $app->resource->get->uri('app://self/hello')->withQuery(['name' => 'Pull world !'])->eager->request();

?>
<html>
    <body>
        greeting: <?php echo $hello['greeting'];?>

        time: <?php echo $hello['time'];?>

    </body>
</html>
