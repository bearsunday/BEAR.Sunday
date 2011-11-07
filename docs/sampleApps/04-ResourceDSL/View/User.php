<?php

// View Class

class User extends View
{
    use DefaultGet;
	
	/**
	 * Inject
	 */
	public function __construct(Page $page, Smarty $smarty, $body)
	{
		$body = array();
		foreach ($page as $key => $value) {
			if ($value instanceof Request) {
				$value = $value->invoke();
			} elseif ($pageElement instanceof \Closure) {
				$value = $value();
			}
			$body[$key] = value;
		}
		$this->body = $body;		
	}
	
	public function onGet(Page $page, Smarty $smarty, $body)
	{
		$template = $page['isValid']) ? 'normal.tpl' : 'invalid.tpl';
		$body = array();
		foreach ($page as $key => $value) {
			if ($value instanceof Request) {
				$value = $value->invoke();
			} elseif ($pageElement instanceof \Closure) {
				$value = $value();
			}
			$body[$key] = value;
		}
		$smarty->assign($body);
		$this->body = $smarty->fetchAll($template);
		$this->header[] = "Content-Type: text/html; UTF-8";
	}	
}