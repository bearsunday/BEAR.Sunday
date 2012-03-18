<?php
namespace demoworld\Resource\Page\Param;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Smarty3 as View;
use BEAR\Resource\Annotation\Provides;
use BEAR\Framework\Inject\WebContextInject;
use BEAR\Resource\Annotation\Get;
use BEAR\Resource\Annotation\Put;
use BEAR\Framework\Args;

/**
 * Parameter injection
 */
class Web extends Page
{
    use View;
    use WebContextInject;

    public function __construct()
    {
    }

    /**
     * @Get
     */
    public function onGet($lang, $role, $name, $age)
    {
        $this['lang'] = $lang;
        $this['role'] = $role;
        $this['name'] = $name;
        $this['age'] = $age;
        return $this;
    }

    /**
     * @Put
     *
     * [AT]QueryParam(var=lang, alt="en")
     * [AT]CookieParam(var=role, alt="user")
     * [AT]FormParam(var=role, alt="user")
     */
    public function onPut($lang, $role)
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

    /**
     * @Provides
     */
    public function provideRestOfParameters(Args &$args)
    {
        $args['name'] = 'BEAR';
        $args['age'] =  6;
    }
}
