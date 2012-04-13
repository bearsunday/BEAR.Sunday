<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>BEAR.Sunday</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BEAR, a resource oritented framework">
    <meta name="author" content="Akihito Koraiyama">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">BEAR.Sunday</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="https://github.com/koriym/BEAR.Sunday">GitHub</a></li>
              <li><a href="http://travis-ci.org/#!/koriym/BEAR.Sunday">Travis</a></li>
              <li><a href="http://code.google.com/p/bearsunday/">Google Code</a></li>
              <li><a href="mailto:koriyama@bear-project.net">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container">
        
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>{$greeting}</h1>
        <p>PHP 5.4+ Resource Oriented Framework</p>
        <p><a class="btn btn-primary btn-large" href="https://github.com/koriym/BEAR.Sunday">View project on GitHub &raquo;</a></p>
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
            <li>apc <code>{$extentions.apc}</code></li>
          </ul>
          <h3>optional</h3>
          <ul>
            <li>curl <code>{$extentions.curl}</code></li>
            <li>memcache <code>{$extentions.memcache}</code></li>
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
           <p> Ray.Di - Guice style annotation-driven dependency injection framework,</p>
           <p> Ray.Aop package provides method interception. This feature enables you to write code that is executed each time a matching method is invoked. </p>
           <p> BEAR.Resource - RESTful service layer framework.</p>
       </div>
        <div class="span4">
          <h2>Sample apps</h2>
          <ul>
            <li><a href="/hello/world">Hello World</a></li>
            <li><a href="/blog/posts">Blog tutorial</a></li>
          </ul>
          <p><a class="btn" href="http://code.google.com/p/bearsunday/wiki/blog">Try tutorial &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2012 <a href="https://twitter.com/#!/bearsunday">@BEARSunday</a></p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
