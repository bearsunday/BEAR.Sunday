<?php
/**
 * Run all example
 *
 * $ php runall.php
 */
echo "min\n";

passthru('php apps/helloworld/htdocs/min.php');
echo "\n";

echo "app resource\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /helloresource');

echo "template engine\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /template/twig');
passthru('php apps/demoworld/htdocs/dev.web.php get /template/smarty3');
passthru('php apps/demoworld/htdocs/dev.web.php get /template/haanga');
passthru('php apps/demoworld/htdocs/dev.web.php get /template/php');

echo "AOP\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /aop/log');

echo "http resource\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /http/googlenews');
passthru('php apps/demoworld/htdocs/dev.web.php get /http/multi');

echo "api app resource\n";

passthru('php apps/demoworld/htdocs/dev.api.php get app://self/greeting?lang=en');
passthru('php apps/demoworld/htdocs/dev.api.php get app://self/greeting?lang=ja');

echo "another app page as resource\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /app/hello');

echo "hyper link api\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /hyperlink/restbucks?drink=latte');
passthru('php apps/demoworld/htdocs/dev.web.php get /hyperlink/restbucks?drink=coffee');

echo "uri router\n";

passthru('php apps/demoworld/htdocs/dev.web.php get /helloresource/ja');
passthru('php apps/demoworld/htdocs/dev.web.php get /helloresource/en');

echo "cache\n";

passthru("php apps/demoworld/htdocs/dev.api.php get 'page://self/cache/page?name=koriym'");
passthru("php apps/demoworld/htdocs/dev.api.php get 'page://self/cache/page/onesec?name=koriym'");
passthru("php apps/demoworld/htdocs/dev.api.php get 'page://self/cache/page/onesec?name=koriym'");
passthru("php apps/demoworld/htdocs/dev.api.php put 'page://self/cache/page/onesec?name=koriym'");
passthru("php apps/demoworld/htdocs/dev.api.php get 'page://self/cache/page/onesec?name=koriym'");
