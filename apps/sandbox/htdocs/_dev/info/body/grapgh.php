<?php $graph = require dirname(__FILE__) . '/graph.php' ?>
<!DOCTYPE html>
<html>
<head>
  <!-- Kenneth Kufluk 2008/09/10 -->
  <title>Object Graph View</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <base href="/_dev/js/graph/">
  <link rel="stylesheet" type="text/css" href="mindmap.css" />
  <!-- <link href="style.css" type="text/css" rel="stylesheet"/>-->
  <!-- jQuery -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js" type="text/javascript"></script>
  <!-- UI, for draggable nodes -->

  <!-- Raphael for SVG support (won't work on android) -->
  <script type="text/javascript" src="raphael-min.js"></script>

  <!-- Mindmap -->
  <script type="text/javascript" src="js-mindmap.js"></script>

  <!-- Kick everything off -->
  <script src="script.js" type="text/javascript"></script>
	<script type="text/javascript"> 
	$(document).ready(function() {
        $("#js-mindmap").mindmap({
            showSublines: true,
            canvasError: "alert",
            mapArea: {x:-1, y:-1}
        });
/*
        $("#js-mindmap2").mindmap({
            showSublines: true,
            canvasError: "alert",
            mapArea: {x:400, y:-1}
        });
 */
    });
	</script> 
	<style> 
	#js-mindmap2 {
	   display:none;
	    position:relative;
        margin-left:10px;
    }
	</style> 
</head>
<body>
<h1>Object graph view</h1> 
<p class="credit">Object Graph</p>
<?php echo $graph ?>
</body>
</html>