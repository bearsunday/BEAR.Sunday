<?php

trait Get
{
    /**
     * Inject
     */
    public function __construct(Smarty $smarty)
    {
        $thi->smarty = $smarty;
    }
    
    public function onGet(Page $page)
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

?>