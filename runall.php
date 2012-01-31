<?php
/**
 * Run all example
 *
 * $ php runall.php
 */
echo "min\n";

passthru('php apps/00-helloworld-min/htdocs/00-min.ph');
echo "\n";

echo "min app resource\n";

passthru('php apps/01-demo/htdocs/dev.php get /helloresource');

echo "template engine\n";

passthru('php apps/01-demo/htdocs/dev.php get /template/twig');
passthru('php apps/01-demo/htdocs/dev.php get /template/smarty3');
passthru('php apps/01-demo/htdocs/dev.php get /template/haanga');
passthru('php apps/01-demo/htdocs/dev.php get /template/php');

echo "AOP\n";

passthru('php apps/01-demo/htdocs/dev.php get /aop/log');

echo "http resource\n";

passthru('php apps/01-demo/htdocs/dev.php get /http/googlenews');
passthru('php apps/01-demo/htdocs/dev.php get /http/multi');

echo "template engine\n";

passthru('php apps/01-demo/htdocs/dev.php get /template/php');

echo "api app resource\n";

passthru('php apps/01-demo/api/dev.php get app://self/greeting?lang=en');
passthru('php apps/01-demo/api/dev.php get app://self/greeting?lang=ja');

echo "another app page as resource\n";

passthru('php apps/01-demo/htdocs/dev.php get /app/hello');

echo "hyper link api\n";

passthru('php apps/01-demo/htdocs/dev.php get /hyperlink/restbucks?drink=latte');
passthru('php apps/01-demo/htdocs/dev.php get /hyperlink/restbucks?drink=coffee');

echo "uri router\n";

passthru('php apps/01-demo/htdocs/dev.php get /helloresource/ja');
passthru('php apps/01-demo/htdocs/dev.php get /helloresource/en');

echo "cache\n";

passthru("php apps/01-demo/api/dev.php get 'page://self/cache/page?name=koriym'");
