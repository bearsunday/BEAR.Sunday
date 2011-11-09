<?php
namespace BEAR\Framework\HelloWorld;
use Aura\Web\Context as WebContext;

/**
 * Lang by cookie
 */
class CookieWorld extends LnagWorld
{
    /**
     * @Provides("lang")
     */
    public function onProvideLang()
    {
        $lang = $this->webContext->getCookie('lang', 'ja');
        return $lang;
    }
}
