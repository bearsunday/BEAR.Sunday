---
layout: default_ja
title: BEAR.Sunday | Hello World
category: はじめに
---

# Hello World 

最小構成アプリをでBEAR.Sundayアプリの構成を学習します。
このアプリケーションは主に３つのファイルで構成されています。

 * web/cli用アプリケーションスクリプト Helloworld/public/min.php
 * Helloページリソース Helloworld/Resource/Page/Hello.php
 * インスタンススクリプト Helloworld/scripts/instance.php

インスタンススクリプトでアプリケーションオブジェクトを生成し、Helloページリソースをリクエストしてその結果を表示します。

## CLI / Webで実行 

CLIでHello World。

    $ php /path/to/bear/apps/Helloworld/htdocs/min.php

PHP5.4 built-in web serverでHello World。

    $ php -S localhost:8088 /path/to/bear/apps/Helloworld/htdocs/min.php

# リソース用最小構成　

### アプリケーションスクリプト (Helloworld/public/min.php ) 

アプリケーションの実行内容が記述されています。

    // application
    $app = require dirname(__DIR__) . '/scripts/instance.php';
    $response # $app->resource->get->uri('page://self/hello')->withQuery(['name' > 'World !'])->eager->request();

    // output
    foreach ($response->headers as $header) {
        header($header);
    }
    echo $response->body;
    exit(0);

### インスタンススクリプト (Helloworld/scripts/instance.php) 

アプリケーションオブジェクトを生成するスクリプトです。

    $injector = Injector::create([new AppModule]);
    $app = $injector->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
    return $app;

## アプリケーションスクリプトの説明 

アプリケーションスクリプトの各行を説明します。

    $app = require dirname(__DIR__) . '/scripts/instance.php';

アプリケーションのインスタンスをスクリプトで取得します。

    $response # $app->resource->get->uri('page://self/hello')->withQuery(['name' > 'World !'])->eager->request();

アプリケーションオブジェクトのプロパティの一つリソースクライアント($app->resource)で`page://self/hello`というURIを持つリソース`get`メソッドでアクセスしています。クエリー（引き数）を指定し`eager->request()`ですぐに値を取得しています。

    foreach ($response->headers as $header) {
        header($header);
    }
    echo $response->body;

値はHTTPレスポンスと同じようにcode, headers, bodyという３つのプロパティを持っていて出力しています。

## Helloページリソース 

BEAR.SundayではMVCでコントローラーにあたるものはページリソースです。ページリソースはクエリーを引数に受け、自身を構成し返します。

*Helloworld/Resource/Page/Hello.php*

    class Hello extends Page
    {
        /**
         * @return self
         */
        public function onGet($name)
        {
            $this->body = 'Hello ' . $name;
            return $this;
        }
    }

ページリソースはMVCで言えばコントローラーあたる部分ですが、テンプレートに値をセットするのではなく` $this->body = 'Hello ' . $name;`として自らをページオブジェクトとして構成して$thisを返しています。

以下の様に文字列を返しても同じ結果になります。クライアントにはリソースオブジェクトが返るからです。

    {
        $body = 'Hello ' . $name;
        return $body;
    }

## アプリケーションクラス 
*Helloworld/App.php*

アプリケーションオブジェクトはアプリケーションスクリプトが必要とするサービスの全てをプロパティに持ちます。


モジュールでインターフェイスにバインドされたオブジェクトがコンストラクタでインジェクトされます。

## アプリケーションモジュール 
*`Helloworld/Module/AppModule.php`*

アプリケーションモジュールはアプリケーションが必要とする依存と実装の束縛とメソッドと横断的関心事の束縛の集合です。

インジェクトを必要とする"インジェクションポイント"に対し実装を静的束縛するDependency Injection、特定のメソッドに対して横断的関心事のインターセプターを束縛するAspect Oriented Programing、この両者の設定をモジュールで一元して行う事でアプリケーションの構成を行います。