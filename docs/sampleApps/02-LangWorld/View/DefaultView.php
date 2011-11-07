<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\ResourceObject\Resource,
    BEAR\Resource\ResourceObject\Page,
    BEAR\Resource\Cleint;

/**
 * QueryWorld by query
 */
class DefaultView extends View
{
    public $code = 200;
    public $header = array();
    public $body = array();
    
    public function onGet(Ro $ro)
    {
        $this->body += $ro->body;
        foreach ($this->body as $key => &$value) {
            if ($value instanceof Request || $value instanceof \Closure) {
                $value = $value();
            }
        }
        $this->view->assign($this->body);
        $this->body = $this->view->fetchAll($ro);
        $this->header = array('Content-type: text/html; charset=utf-8');
        return $this;
    }
}