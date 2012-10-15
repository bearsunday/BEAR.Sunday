<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
$sec = number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 2);
$memory = number_format(memory_get_peak_usage(true));

$systemRoot = dirname(dirname(dirname(dirname(__DIR__))));

$exceptionInfo = function (\Exception $e) use ($systemRoot) {
    return [
        'message' => $e->getMessage(),
        'traceString' => $e->getTraceAsString(),
        'traceRaw' => 'n/a', //print_r($e->getTrace(), true),
        'file' => $e->getFile(),
        'href' => '/_dev/edit/index.php?file=' . str_replace($systemRoot, '', $e->getFile()) . '&line=' . $e->getLine(),
        'title' => $e->getFile() . ':' . $e->getLine(),
        'line' => $e->getLine(),
        'fileContents' => htmlspecialchars(trim(file_get_contents($e->getFile()))),
        'class' => get_class($e),
        'trace' => $e->getTrace()
    ];
};
$exception = $exceptionInfo($e);
$previousE = $e->getPrevious();
if ($previousE) {
    $previousE = $exceptionInfo($e->getPrevious());
}
$html = <<<EOT
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Exception</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="/assets/js/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
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
          <a class="brand" href="#">Exception</a>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="alert alert-block alert-error fade in">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h1 class="alert-heading">{$exception['class']}</h1>
        <h2>{$exception['message']}</h2>
        <p></p>
        <a  class="btn" target="code_edit" title="{$exception['title']}" href="{$exception['href']}">Edit</a>
        <a class="btn disabled" href="#">Download</a>
      </div>
EOT;
if ($previousE) {
    $html .= <<<EOT
      <div class="alert alert-block alert-warning fade in">
          <span class="badge badge-warning">Previous Exception</span>
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h1 class="alert-heading">{$previousE['class']}</h1>
        <h2>{$previousE['message']}</h2>
        <p></p>
        <a  class="btn" target="code_edit" title="{$previousE['title']}" href="{$previousE['href']}">Edit</a>
        </div>
EOT;
}
$html .= <<<EOT

    <span class="icon-eye-open"></span> Trace Information</span>
    <p></p>
    <ul id="tab" class="nav nav-tabs">
      <li class="active"><a href="#summary" data-toggle="tab">Summary</a></li>
      <li><a href="#file" data-toggle="tab">File</a></li>
      <li><a href="#raw" data-toggle="tab">Raw</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="summary">
      <p><span class="icon-fire"></span><a target="code_edit" href="{$exception['href']}">{$exception['file']} : {$exception['line']}</a></P>
      <p><pre>{$exception['traceString']}</pre></p>
    </div>

    <p><span class="icon-file"></span>Files</P>
EOT;
foreach ($exception['trace'] as $trace) {
    if (isset($trace['file'])) {
        $file = $trace['file'];
        $line = $trace['line'];
        $editFile = str_replace($systemRoot, '', $file);
        $html .= "<a target=\"code_edit\" href=\"/_dev/edit/index.php?file={$editFile}&line={$line}\">{$file}  : {$trace['line']} <span class=\"icon-share-alt\"></span></a><br>";
    }
}
$html .= <<<EOT

    <div class="tab-pane" id="file">
      <pre class="prettyprint linenums">
        {$exception['fileContents']}
      </pre>
    </div>

    <div class="tab-pane" id="raw">
      <p><pre>{$exception['traceRaw']}</pre></p>
    </div>


    <p></p>
     <a class="btn disabled" href="#">Edit</a>

      <footer>
        <hr>
        <span class="icon-time"></span> {$sec} sec
        <span class="icon-signal"></span> {$memory} bytes
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
    <script src="/assets/js/google-code-prettify/prettify.js"></script>
    <script>$(function () { prettyPrint() })</script>
</script>
  </body>
</html>
EOT;
return $html;
