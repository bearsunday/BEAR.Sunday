<?php
namespace BEAR\Framework\HelloWorld;
use Aura\Web\Context as WebContext;

/**
 * Lang by cookie
 */
class CookieWorld extends LangWorld
{
    use DefaultWeb;
    
    public function onGet()
    {
        $this['lang'] = $this->webContext->getQuery('lang', 'ja');
        return $this;
    }    
    
}