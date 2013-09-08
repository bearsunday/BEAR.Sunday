---
layout: default_ja
title: BEAR.Sunday | はじめてのリソース
category: 「はじめての」チュートリアル
--- 
# はじめてのリソース
## アプリケーションリソース 

ここでは`name`を渡すと挨拶を返してくれる`greeting`リソースをつくってみます。
MVCでいうとモデルにあたる部分をBEAR.Sundayではアプリケーション(app)リソースと呼びます。アプリケーションリソースはアプリケーションの内部APIとして利用されます。

## リソース設計 

リソースとは情報のかたまりです。ここでは挨拶(`greeting`)が「挨拶リソース」として使われます。リソースオブジェクトクラスには以下のものが必要です。

 * URI
 * リクエストインターフェイス 

ここではこういう風に決めました。

|| URI || メソッド || クエリー ||
|| app://self/first/greeting || get || ?name=名前 ||

期待するgreetingリソースはこういうものです。

リクエスト
```
get app://self/first/greeting?name=BEAR
```
レスポンス
```
Hello, BEAR.
```

## リソースオブジェクト 

sandboxアプリケーションに実装します。URIとPHPのクラス、ファイル位置はこのように対応します。

|| URI || Class || File ||
|| `app://self/first/greeting` || `Sandbox\Resource\App\First\Greeting` || `apps/Sandbox/Resource/App/First/Greeting.php` ||

リクエストインターフェイス（メソッド）を実装します。
```
namespace Sandbox\Resource\App\First;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Greeting extends AbstractObject
{
    /**
     * Get
     *
     * @param  string $name
     * 
     * @return string
     *
     */
    public function onGet($name)
    {
        return "Hello, {$name}";
    }
}
```


## コマンドラインでためしてみましょう 

ではコマンドラインインターフェイス(CLI)で試してみましょう。コンソールから入力します。まずは*失敗*から。

```
php api.php get app://self/first/greeting
```
400 Bad Requestのレスポンスが帰ってきます。
```
400 Bad Request
...
[BODY]
Internal error occured (e613b4)
```
ヘッダーをみると例外発生の情報があり、クエリーにnameが必要だというこ
とがわかります。*`OPTIONS`メソッド* を使ってもっと正確に調べてみることができます。

```
php api.php options app://self/first/greeting
```

```
200 OK
allow: ["get"]
param-get: name
```

このリソースは`GET`メソッドだけが有効で、パラメーターは１つ、`name`が必要だというのが分かります。もしこの`name`パラメーターがオプションであるなら(name)と表示されます。では引き数がOPTIONSメソッドでわかったところで再度試してみます。

```
php api.php get 'app://self/first/greeting?name=BEAR'
```
```
200 OK
cache-control: no-cache
date: Tue, 10 Jul 2012 23:55:16 GMT
content-type: text/html; charset=UTF-8
[BODY]
"Hello, BEAR"
```
今度は正しいレスポンスが返ってきました。成功です！

## リソースオブジェクトが返ります 

この挨拶リソース実装では文字列を返していますが、以下の記述のと同じものとして扱われます。どちらの記述でもリクエストしたクライアントのはリソースオブジェクトが返ります。

```
public function onGet($name)
 {
    $this->body = "Hello, {$name}";
    return $this;
}
```

`onGet`メソッド内をこのように変えてレスポンスが変わらない事を確認してみましょう。