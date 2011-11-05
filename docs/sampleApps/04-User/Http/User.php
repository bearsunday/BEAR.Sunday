<?php

// View Class

class User extends View
{
	public function __construct()
	{
	}
	
	public function onGet(View $view)
	{
	    foreach ($page->header as $header) {
	        header($header);
	    }
	    echo $page->body;
	}	
}