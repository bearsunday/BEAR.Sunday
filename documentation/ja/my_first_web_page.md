#summary はじめてのwebページ

# Webページにしましょう 

## ページリソース 

まず最初に*アプリケーションリソースを利用しない最小限のページクラスを作成します。*  （モデルを使わないコントローラーだけのHelloWorldページのようなページです。)

## 最小構成のページから始めます 

アプリケーションリソースがリソースの状態を構成したように、ページリソースでもページリソースがページの状態を構成します。

 挨拶が"Hello"と固定化されている静的なページです。

{{{
<?php
namespace Sandbox\Resource\Page\First;

use BEAR\Resource\AbstractPage as Page;

/**
 * Greeting page
 */
class Greeting extends Page
{    
    public $body = [
        'greeting' => 'Hello.'
    ];

    public function onGet()
    {
        return $this;
    }
}
}}}

ページのコンテンツの"greeting"というスロットに'Hello.'という文字列を格納しています。GETリクエストは呼ばれると何もしないで自身を返しています。

## コマンドラインでページリソース状態確認します 

このリソースをコマンドラインで確認してみましょう。

{{{
$ cd apps/Sandbox/htdocs/
$ php api.php get page://self/first/greeting

200 OK
...
[BODY]
greeting:Hello.
}}}

greetingというスロットに`Hello.`という文字列が入っているのが確認できました。

## ページリソースの状態を表現にします 

このページリソースの状態をHTML表現としてレンダリングするためにテンプレートが必要です。リソースと同じ場所に拡張子だけ変更します。

### ファイルパス 

|| URI || `page://self/first/greeting` ||
|| リソースクラス || `apps/Sandbox/Resource/Page/First/Greeting.php` ||
|| リソーステンプレート || `apps/Sandbox/Resource/Page/First/Greeting.tpl` ||


### テンプレート 
{{{
<!DOCTYPE html>
<html lang="en">
  <body>
      <h1>{$greeting}</h1>
  </body>
</html>
}}}
## コマンドラインでページHTMLを確認します 

リソースの状態をテンプレートにアサインしてレンダリングするとリソースのHTML表現になります。つまりHTMLページになります。これもコマンドラインで
確認することができます。

では確認してみましょう。

{{{
$ php web.php get /first/greeting
}}}
{{{
200 OK
cache-control: ["no-cache"]
date: ["Fri, 01 Feb 2013 14:21:45 GMT"]
[BODY]
<!DOCTYPE html>
<html lang="en">
<body>
<h1>Hello, anonymous</h1>
</body>
</html>
HTMLが確認できました。

 Note:開発用途で動作させてるのでヘッダーには、`x-`ではじまる開発用の様々な情報が入っています。

## webブラウザでページHTMLを確認します 

ビルトインウェブサーバーを立ち上げます
{{{
$ php -S localhost:8088 web.php
}}}

http://localhost:8088/first/greeting をアクセスします。
無事ページが見えたでしょうか？

## ページの役割 

ページは情報のかたまり（リソース）を集めページ自身を構成します。ここでは１つの"greeting"というスロットに"Hello"という文字列の情報を格納しましたが、多くのページは複数のスロットがあるでしょう。

ページの役割は、ページを構成する他のリソースを合成しページの状態を決定する事です。リソース状態はリソーステンプレートと合成されリソース表現(HTML)になりユーザーに転送され表示されます。