<?php
namespace BEAR\Framework\HelloWorld;
use Aura\Web\Context as WebContext;

/**
 * Lang by cookie
 */
class LangCookie extends LangWorld
{
    /**
     * @var WebContext
     */
    private $webcontext;
    
    /**
     * @Inject
     */
    public function setWebContext(WebContext $webcontext)
    {
        $this->webcontext = $webcontext;
    }
    
    /**
     * @Web
     */
    public function onWeb(WebContext $webContext)
    {
        $this->inject('lang', $this->webContext->getCookie('lan', 'ja'); // by cookie
    }    
}