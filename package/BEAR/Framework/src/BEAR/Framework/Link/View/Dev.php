<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Link\View;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Framework\AbstractAppContext as App;

/**
 * Trait for debug view link
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait Dev
{
    /**
     * @Inject
     */
    public function setApp(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param ResourceObject
     */
    public function onLinkView(ResourceObject $page)
    {
        foreach ($page as &$resource) {
            if (is_callable($resource)) {
                $resource = $resource();
            }
        }
        $body = (array)$page->body;
        if (is_array($body)) {
            foreach ($body as $key => &$appResource) {
                if ($appResource instanceof \ArrayObject) {
                    $appResource = (array)$appResource;
                }
            }
        }
        ob_start();
        $responce = [
            'code'=> $page->code,
            'headers' => $page->headers,
            'body' => $body
        ];
        var_export($responce);
        $buffer = ob_get_clean();
        $this->body = $buffer;
        return $page;
    }
}