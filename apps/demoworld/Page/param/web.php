<?php
namespace demoworld\Page\Param;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Php as PhpView;
use BEAR\Resource\Annotation\Provides;
use BEAR\Framework\Inject\WebContextInject;

/**
 * Parameter injection
 */
class Web extends Page
{
    use PhpView;
    use WebContextInject;

    public function __construct()
    {
    }

    /**
     * @Get
     */
    public function onGet($lang, $role)
    {
        $this['lang'] = $lang;
        $this['role'] = $role;
        return $this;
    }

    /**
     * @Put
     *
     * [AT]QueryParam(var=lang, alt="en")
     * [AT]CookieParam(var=role, alt="user")
     * [AT]FormParam(var=role, alt="user")
     */
    public function onGet($lang, $role)
    {
        $this['lang'] = $lang;
        $this['role'] = $role;
        return $this;
    }

    /**
     * @Provides("lang")
     */
    public function provideLang()
    {
        $lang = $this->webContext->getQuery('lang', 'es');
        return $lang;
    }

    /**
     * @Provides("role")
     */
    public function provideRole()
    {
        $role = $this->webContext->getCookie('role', 'user');
        return $role;
    }
}
