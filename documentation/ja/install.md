---
layout: default_ja
title: BEAR.Sunday | インストール
category: インストールと設定
---
# インストール

## 必要要件 

 * PHP 5.4
 * [curl](http://php.net/manual/ja/book.curl.php)

## 推奨 
 * [APC](http://php.net/manual/ja/book.apc.php) 

## 開発用オプション 
 * プロファイラ　[xhprof](http://jp.php.net/manual/en/book.xhprof.php)
 * コールグラフ描画 [graphviz](http://www.graphviz.org/)

# インストール 
composerでsandboxアプリケーションをインストールします。

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar create-project -s dev --dev bear/package ./bear

## 環境確認 

    $ php bin/env.php

必要なphp.iniの状態の確認、DB接続のテストを行います。

### DBの接続確認 

DBの接続ができないときはコンソールで以下のコマンドでPHPとmysqlが正しくセットアップできてるかをお試しください。エラーが出なければ問題ありません。

※ root/(パスワードなし）の場合

    $ php -r 'new mysqli("localhost", "root", "", "mysql");'
    $ php -r 'new PDO("mysql:host# localhost;dbnamemysql", "root", "");'

インストールに問題がある場合は[FAQ:インストール](http://code.google.com/p/bearsunday/wiki/faq#%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB%E3%81%A7%E3%81%AE%E5%95%8F%E9%A1%8C)をご覧下さい。

## DB接続 

`localhost`に`root/（パスなし)`で接続できる場合は設定不要です。
そうでない場合はIDとパスワードを指定します。二種類の方法があります。

### 1) 環境変数で設定（推奨）

下記の変数を設定して、PHPが環境変数を読めるようにphp.iniを設定します。

|| BEAR_DB_ID || ID || 
|| BEAR_DB_PASSWORD || パスワード ||

オプションでSLAVE DBも設定できます。
|| BEAR_DB_ID_SLAVE || ID（SLAVE DB) || 
|| BEAR_DB_PASSWORD_SLAVE || パスワード（SLAVE DB) ||

例) "root" / "password" を環境変数として~/.bashrcでエクスポート

~/.bashrc 追記

    export BEAR_DB_ID=root
    export BEAR_DB_PASSWORD=password

~/.bashrcでエクスポート

    . ~/.bashrc

### 2) ファイルで設定

`apps/Sandbox/Module/config.php`を編集して直接値を指定します。

## DBの作成 
テストを実行するためにsandboxアプリで利用するDBとテスト用のDBを作成します。

シェルスクリプト、または手動で入力します。

### シェルスクリプトで（推奨） 

    $ apps/Sandbox/scripts/install_db.sh

※DBのID、パスワードを必要に応じて変更します。
### 手動で 

blogbearデーターベースを作成

    CREATE DATABASE `blogbear` DEFAULT CHARACTER SET 'utf8';

postsテーブルを作成

    CREATE TABLE posts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(50),
        body TEXT,
        created DATETIME DEFAULT NULL,
        modified DATETIME DEFAULT NULL
    );
    /* それから、テスト用に記事をいくつか入れておきます。 */
    INSERT INTO posts (title,body,created)
    VALUES ('タイトル', 'これは、記事の本文です。', NOW());
    INSERT INTO posts (title,body,created)
    VALUES ('またタイトル', 'そこに本文が続きます。', NOW());
    INSERT INTO posts (title,body,created)
    VALUES ('タイトルの逆襲', 'こりゃ本当に面白そう！うそ。', NOW());

### ユニットテスト用データベースの準備 
こちらはテスト毎にセット/破棄されるのでコンテンツを用意しておく必要はありません。

    CREATE DATABASE `blogbeartest` DEFAULT CHARACTER SET 'utf8';

    CREATE TABLE posts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(50),
        body TEXT,
        created DATETIME DEFAULT NULL,
        modified DATETIME DEFAULT NULL
    );

# sandboxアプリケーション実行 

BEAR.SundayのアプリケーションはWebまたはCLI双方からアクセスできます。
[https://github.com/koriym/BEAR.package#buil-in-web-server-for-development buil-in web server for development]をご覧下さい

## コンソールアクセス 

    $ cd apps/Sandbox/public
    $ php web.php get /index
    $ php api.php get page://self/index
    $ php api.php get 'app://self/first/greeting?name=World'
    $ php api.php options app://self/blog/posts
    $ php api.php post 'app://self/blog/posts?title# hello&bodyworld'


### Web (HTML) 
    $ cd apps/Sandbox/public
    $ php -S localhost:8088 web.php
### API (JSON+HAL)
    $ cd apps/Sandbox/public
    $ php -S localhost:8089 api.php

## プロダクション 
`public/index.php`をweb公開エリアに設置してください。

# Unit Test 
## テスト環境

    $ pear config-set auto_discover 1
    $ pear install pear.phpunit.de/PHPUnit
    $ pear install phpunit/DbUnit
    $ pear install phpunit/PHP_Invoker

 Note: 環境によっては、root として実行しなければならないかもしれません。

## テスト実行 
    $ phpunit

## トラブルシューティング 
[faq FAQ]をご覧下さい。