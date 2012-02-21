<?php
/**
 * Run all example
 *
 * $ php runall.php
 */
echo "min\n";

//passthru('php apps/helloworld/htdocs/00-min.php');
echo "\n";

echo "app resource\n";

passthru('php apps/demoworld/htdocs/dev.php get /helloresource');

echo "template engine\n";

passthru('php apps/demoworld/htdocs/dev.php get /template/twig');
passthru('php apps/demoworld/htdocs/dev.php get /template/smarty3');
//passthru('php apps/demoworld/htdocs/dev.php get /template/haanga');
passthru('php apps/demoworld/htdocs/dev.php get /template/php');

echo "AOP\n";

passthru('php apps/demoworld/htdocs/dev.php get /aop/log');

echo "http resource\n";

passthru('php apps/demoworld/htdocs/dev.php get /http/googlenews');
passthru('php apps/demoworld/htdocs/dev.php get /http/multi');

echo "api app resource\n";

passthru('php apps/demoworld/api/dev.php get app://self/greeting?lang=en');
passthru('php apps/demoworld/api/dev.php get app://self/greeting?lang=ja');

echo "another app page as resource\n";

passthru('php apps/demoworld/htdocs/dev.php get /app/hello');

echo "hyper link api\n";

passthru('php apps/demoworld/htdocs/dev.php get /hyperlink/restbucks?drink=latte');
passthru('php apps/demoworld/htdocs/dev.php get /hyperlink/restbucks?drink=coffee');

echo "uri router\n";

passthru('php apps/demoworld/htdocs/dev.php get /helloresource/ja');
passthru('php apps/demoworld/htdocs/dev.php get /helloresource/en');

echo "cache\n";

passthru("php apps/demoworld/api/dev.php get 'page://self/cache/page?name=koriym'");
