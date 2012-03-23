<?php
// router.php
if (preg_match('/\.(?:png|jpg|jpeg|css|gif)$/', $_SERVER["REQUEST_URI"]))
    return false;    // serve the requested resource as-is.
	else { 
	    echo "<p>Welcome to PHP</p>";
		}
		?>

