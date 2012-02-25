<?php
namespace BEAR\Framework;

use ArrayObject;
use BEAR\Resource\Exception\BadRequest,
    BEAR\Resource\Exception\MethodNotAllowed;


class Globals extends ArrayObject
{
    /**
     *
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        if (count($argv) !== 3) {
            throw new BadRequest((string)count($argv));
        }
        $isMethodAllowed = in_array($argv[1], ['get', 'post', 'put', 'delete', 'head', 'options']);
        if (! $isMethodAllowed) {
            throw new MethodNotAllowed($argv[1]);
        }
        $globals['_SERVER']['REQUEST_METHOD'] = $argv[1];
        $globals['_SERVER']['REQUEST_URI'] = parse_url($argv[2], PHP_URL_PATH);
        parse_str(parse_url($argv[2], PHP_URL_QUERY), $get);
        $globals['_GET'] = $get;
        parent::__construct($globals);
    }
}
