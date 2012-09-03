<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>BEAR.Sunday</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BEAR, a resource oritented framework">
    <meta name="author" content="Akihito Koraiyama">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>


    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
          </a>
          <a class="brand" href="#">BEAR.Sunday</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="mailto:koriyama@bear-project.net">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<!-- Subhead
================================================== -->    
    <div class="container">
        
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>{$greeting}</h1>
        <p>A Resource Oriented Framework for PHP5.4</p>
        <p><a class="btn btn-primary btn-large" href="https://github.com/koriym/BEAR.Sunday">View project on GitHub &raquo;</a> 
        <a rel="tooltip" title ="{$apc.size} bytes of {$apc.total} user APC entries will be cleard." class="btn btn-primary btn-large btn btn-warning" href="/_dev/refresh.php"><i class="icon-refresh"></i> Refresh</a></p> 
      </div>
      <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h2>Version Info</h2>
          <ul>
            <li>BEAR.Sunday <code>{$version.BEAR}</code></li>
            <li>PHP <code>{$version.php}</code></li>
          </ul>
          <h2>Extension</h2>
          <h3>mandatory</h3>
          <ul>
            <li><a href="http://www.php.net/apc">apc</a> <code>{$extentions.apc}</code></li>
            <a class="btn" href="/_dev/apc.php" id="apc" rel="tooltip" title="Open APC admin cotroll panel">APC Admin  &raquo;</a>
            <a class="btn btn-success" href="/_dev/apc.php?SCOPE=A&SORT1=H&SORT2=D&COUNT=20&OB=3&object_only" id="apc" rel="tooltip" title="APC stored object">APC Objects &raquo;</a>
          </ul>
          <h3>optional</h3>
          <ul>
            <li>memcache <code>{$extentions.memcache}</code></li>
            <p><a class="btn" href="_dev/memcache.php/" id="memchace" rel="tooltip" title="Open memcache admin cotroll panel">Memcache Admin &raquo;</a></p>
            <li>pdo_sqlite <code>{$extentions.pdo_sqlite}</code></li>
            <li>mysqlnd <code>{$extentions.mysqlnd}</code></li>
            <li>Xdebug <code>{$extentions.Xdebug}</code></li>
            <li>xhprof <code>{$extentions.xhprof}</code></li>
          </ul>
        </div>
        <div class="span4">
          <h2>Techniques</h2>
          <ul>
            <li>Dependency Injection</li>
            <li>Aspect Orietned Design</li>
            <li>Representational State Transfer</li>
          </ul>
           <p> <code>Ray.Di</code> - Guice style annotation-driven dependency injection framework <a href="http://travis-ci.org/koriym/Ray.Di"><img src="https://secure.travis-ci.org/koriym/Ray.Di.png"></a> </p>
           <p> <code>Ray.Aop</code> package provides method interception. This feature enables you to write code that is executed each time a matching method is invoked. <a href="http://travis-ci.org/koriym/Ray.Aop"><img src="https://secure.travis-ci.org/koriym/Ray.Aop.png"></a> </p>
           <p> <code>BEAR.Resource</code> - RESTful service layer framework. <a href="http://travis-ci.org/koriym/BEAR.Resource"><img src="https://secure.travis-ci.org/koriym/BEAR.Resource.png"></a> </p>
       </div>
        <div class="span4">
          <h2>Sample apps</h2>
          <ul>
            <li><a href="{href rel="helloworld"}">Hello World</a></li>
            <li><a href="{href rel="blog"}">Blog tutorial</a></li>
          </ul>
          <p><a class="btn" href="http://code.google.com/p/bearsunday/wiki/blog">Try tutorial &raquo;</a></p>
          <h2>Links</h2>
              <ul>
              <li><i class="icon-book"></i><a href="http://code.google.com/p/bearsunday/wiki/manual?tm=6">BEAR.Sunday Manual</a></li>
              <li><i class="icon-book"></i><a href="http://code.google.com/p/rayphp/wiki/Motivation?tm=6">Ray.Di / Ray.AOP Manual</a></li>
              <li><i class="icon-fire"></i><a href="https://github.com/koriym/BEAR.Sunday/issues">Issues</a></li>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2012 <a href="https://twitter.com/#!/bearsunday">@BEARSunday</a> ({$performance} page / sec)</p>
      </footer>

    </div> <!-- /container -->
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
{*
     <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
*}
  </body>
</html>
