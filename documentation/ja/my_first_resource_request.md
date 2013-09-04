#summary はじめてのリソースリクエスト

## アプリケーションリソースを利用します 

今までのチュートリアルではコンソールやwebブラウザからリソースをリクエストしていましたが、このチュートリアルではリソースからリソースのリクエストを行います。

ここでは[my_first_web_page はじめてのwebページ]で作成したページを[my_first_resource はじめてのリソース]を利用したものに変更します。

ページリソースがアプリケーションリソースをリクエストしています。ページリソースはページに関心を持つリソースです。通常、ページリソースは自身（ページ）を構成するために必要なアプリケーションリソースをリクエストして自らを構成します。


 Note: 例えていうとコントローラーが"Hello World"を返してたページが、モデルが返した"Hello World"を表示するページに変更します。

## リソースクライアントの準備 

BEAR.Sundayでは必要なサービス（オブジェクト）は基本的に全て外部からインジェクトしてもらうのを期待します。リソースリクエストにはリソースクライアントが必要です。

リソースクライアントインターフェイス（`BEAR\Resource\ResourceInterface`）をタイプヒントにして@Injectとアノテーションでマークするとインジェクト（外部から代入）してもらいます。

{{{
use BEAR\Resource\ResourceInterface;
use Ray\Di\Di\Inject;
}}}
{{{
class User
{
    /**
     * @Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}}}

## traitセッターの利用 
このセッターはtraitとして用意されていてこのように表記できます。
{{{
use BEAR\Sunday\Inject\ResourceInject;

class User
{
    use ResourceInject;
}
}}}

## GETリクエスト 

`app://self/first/greeting`というURIのアプリケーションリソースに?name=$nameのクエリーを付けたリソースリクエストを行うのはこのようなメソッドになります。

{{{
    /**
     * Get
     *
     * @param  string $name
     */
    public function onGet($name = 'anonymous')
    {
        $this['greeting'] = $this->resource
        ->get
        ->uri('app://self/first/greeting')
        ->withQuery(['name' => $name])
        ->request();
        
        return $this;
    }
}}}

## `$_GET`クエリー 

`$_GET['name']`の内容が引き数の`$name`に渡ります。`$_GET['name']`が存在しない場合はデフォルトの'anonymous'が渡されます。

## コマンドラインでページを確認 

'greeting'スロットには`'app://self/first/greeting'`リソースのリクエストが格納されました。

## APIとして確認 

まずAPIとしてページリソースを確認します。

{{{
$ php api.php get 'page://self/first/greeting?name=BEAR'
}}}
{{{
200 OK
cache-control: no-cache
date: Fri, 13 Jul 2012 13:47:28 GMT
content-type: text/html; charset=UTF-8
[BODY]
greeting:Hello, BEAR
}}}

`greeting`スロットに'Hello, BEAR'が渡されてます。クエリーを無くすとどうなるでしょうか。

{{{
$ php api.php get 'page://self/first/greeting'
}}}
{{{
200 OK
content-type: ["application\/hal+json; charset=UTF-8"]
cache-control: ["no-cache"]
date: ["Mon, 12 Nov 2012 01:32:07 GMT"]
[BODY]
{
    "greeting": "Hello, anonymous",
    "_links": {
        "self": {
            "href": "page://self/first/greeting"
        }
    }
}
}}}

デフォルトの値が代入されてるのが確認できます。

## ページテンプレートを用意 

ページリソース用のテンプレートは同じです。
{{{
<!DOCTYPE html>
<html lang="en">
  <body>
      <h1>{$greeting}</h1>
  </body>
</html>
}}}

## HTMLをコマンドラインで確認 

{{{
$ php web.php get '/first/greeting?name=Sunday'
}}}
{{{
200 OK
cache-control: ["no-cache"]
date: ["Fri, 01 Feb 2013 14:27:46 GMT"]
[BODY]
<!DOCTYPE html>
<html lang="en">
<body>
<h1>Hello, Sunday</h1>
</body>
</html>
}}}

## ページのテスト 
ページもリソースです。テストの仕方は[my_first_test はじめてのテスト]で紹介をしたようにページリソースをテストします。