#summary はじめてのハイパーメディア

# ハイパーメディア 

## ハイパーメディアとはなんでしょうか 

1962年、Ted Nelson氏が[ハイパーテキスト](http://ja.wikipedia.org/wiki/%E3%83%8F%E3%82%A4%E3%83%91%E3%83%BC%E3%83%86%E3%82%AD%E3%82%B9%E3%83%88)`を発案しました。これはテキストが他のテキストを参照するための参照リンクをテキストに埋め込むというもので、テキスト間を結びつける参照をハイパーリンクと呼びます。

最も有名で成功したハイパーテキスト実装がWWWです。（`<a>`タグの`href`はハイパーリファレンスの略です。）これをテキストに制限しないであらゆるメディアにしたのがハイパーメディアです。重要なのは*相互参照(hyper reference)のためのリンク*が埋め込まれてるということです。

ちなみにPHPは *PHP: Hypertext Preprocessor* の略です。([http://www.php.net/manual/ja/faq.general.php#faq.general.acronym PHP とは何の略ですか?])

## ハイパーメディアではないもの 

例えばコーヒーショップでコーヒーをオーダーする、これを`REST API`として考えてみます。

飲み物を注文する`REST API`が以下の様に与えられています。

|| METHOD || POST ||
|| URI || `http://restbucks.com/order/{?drink}` ||
|| Query || drink=ドリンク名 ||

この`API`を使って飲み物を注文します。これのAPIを使って`注文リソース`を作成(POST)します。

{{{
post http://restbucks.com/order/?drink=latte
}}}

注文リソースは作成され注文内容が返ってきました。

{{{
{
    "drink": "latte",
    "cost": 2.5,
    "id": "5052",
}
}}}

これは*ハイパーメディアではありません*。情報を一意に現すURIが付いていないし参照リンクもありません。

## HAL - Hypertext Application Language 

JSONは本来ハイパーメディアのためのフォーマットではありませんが、`JSON+HAL`というメディアタイプを与えハイパーメディアとしてJSONを扱おうという[http://stateless.co/hal_specification.html HAL - Hypertext Application Language]という[RFCドラフト規格](http://tools.ietf.org/html/draft-kelly-json-hal-00)があります。BEAR.Sundayではリソースのレンダリングを`HalRenderer`にすることでHALフォーマットで出力することができます。

{{{
{
    "drink": "latte",
    "cost": 2.5,
    "id": "1545",
    "_links": {
        "self": {
            "href": "app://self/restbucks/order?id=1545"
        },
        "payment": {
            "href": "app://self/restbucks/payment?id=1545"
        }
    }
}
}}}

これが`HAL`のフォーマットで出力された注文リソースです。自己のURIと関連するリンクの情報が`_links`に埋め込まれています。注文と支払いの*関係性*をクライアントでなくサービスが保持しています。

サービス側はサービスの都合でリンク先を変える事ができます。そのときにクライアントの利用に変更はありません。リンクを辿るだけです。リンクを持つ事でデータは単なるフォーマットから自己記述的なハイパーメディアになりました。

## ハイパーリンクを追加する 

リソースオブジェクトの`links`プロパティでこのように指定します。
{{{
    public $links = [
        'news' # > [Link::HREF > 'page://self/news/today']
    ];
}}}

## クエリーをURIテンプレートを使う 

URIが動的に決まる場合にはこのようにonPost等のメソッド内でクエリーをつくることもできます。
{{{
$this->links['friend'] # [Link::HREF => "app://self/sns/friend?id{$id}"];
}}}

`links`プロパティでこのようにURIテンプレートを指定することもできます。

{{{
    public $links => [
        'friend' # > [Link::HREF => 'app://self/sns/friend{?id}', Link::TEMPLATED > true]
    ];
}}}

ここに必要な変数`{id}`はリソース`body`から取得されます。

## 試してみましょう

`$item`を指定すると注文リソースを作成するクラスです。

{{{
<?php
namespace Sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Resource\Link;

/**
 * Greeting resource
 */
class Order extends AbstractObject
{
    public function onPost($item)
    {
        $this['item'] = $item;
        $this['id'] = date('is'); // min+sec

        return $this;
    }
}

}}}

これにハイパーリンクを加えるために`links`プロパティを設置します。
{{{
    public $links = [
        'payment' # > [Link::HREF => 'app:/self/first/hypermedia/payment{?id}', Link::TEMPLATED > true]
    ];
}}}

## コンソールでAPIリクエストしてみます

{{{
$ api get app://self/first/hypermedia/user?id=1
}}}
{{{
200 OK
content-type: application/hal+json; charset=UTF-8
[BODY]
{
    "item": "book",
    "id": "1442",
    "_links": {
        "self": {
            "href": "app://self/first/hypermedia/order?item=book"
        },
        "payment": {
            "href": "app:/self/first/hypermedia/payment{?id}",
            "templated": true
        }
    }
}
}}}

`payment`リンクが現れるようになりました。

## リンクをプログラムで利用する

リンクをコードで利用するためには`use AInject;`で`A`オブジェクトをインジェクトしてその`href`メソッドでリンクを取得します。リソースのボディがURIテンプレートに合成されてリンクが取得できます。

{{{
<?php
namespace Sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Inject\AInject;
/**
 * Greeting resource
 */
class Shop extends AbstractObject
{
    use ResourceInject;
    use AInject;

    public function onPost($item, $card_no)
    {
        $order = $this
        ->resource
        ->post
        ->uri('app://self/first/hypermedia/order')
        ->withQuery(['item' => $item])
        ->eager
        ->request();

        $payment = $this->a->href('payment', $order);

        $this
        ->resource
        ->put
        ->uri($payment)
        ->withQuery(['card_no' => $card_no])
        ->request();

        $this->code = 204;
        return $this;
    }
}
}}}

Webページでリンクをクリックするだけで次のページに移れるように、次のリンクをサービス側がコントロールできるようになりました。リンク先に変更があってもクライアントには変更がありません。