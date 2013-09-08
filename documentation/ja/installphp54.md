---
layout: default_ja
title: BEAR.Sunday | PHP5.4インストール
category: インストールと設定
---

# PHP5.4インストール

OSXにPHP5.4環境を構築する一例です。この例では[http://php-osx.liip.ch/](http://php-osx.liip.ch/)からPHPをバイナリインストールします。必要なエクステンションも全てインストールされます。/usr/local/php5を使用しますが、その他のディレクトリには影響がありません。

## PHPインストール 

コンソールから入力します。

    $ curl -s http://php-osx.liip.ch/install.sh | bash -s 5.4

バージョンを確認します。

    $ /usr/local/php5/bin/php -v

    PHP 5.4.2 (cli) (built: May  8 2012 09:48:57) 
    Copyright (c) 1997-2012 The PHP Group
    Zend Engine v2.4.0, Copyright (c) 1998-2012 Zend Technologies
        with Xdebug v2.2.0rc2, Copyright (c) 2002-2012, by Derick Rethans

## iniファイル編集 

iniファイルの位置を確認

    $ php --ini

apc.iniとxhprof.iniを編集します

/usr/local/php5/php.d/50-extension-apc.ini

    extension=/usr/local/php5/lib/php/extensions/no-debug-non-zts-20100525/apc.so
    apc.enable_cli = on

/usr/local/php5/php.d/50-extension-xhprof.ini

    xhprof.output_dir = /tmp

## MySQLのインストール 
[http://dev.mysql.com/downloads/mysql/ Download MySQL Community Server]からDMGファイルをダウンロードしてインストールします。

## Apache 
純正のものを使用します。

### mysql用ソケットファイルの指定 

MySQLを上記のDMGインストールでインストールしているなら、この指定は不要です。 macports等でmysqlをインストールしている場合は、下記のように指定する必要があります。

ソケットファイルの位置を、mysqladminコマンドで調べて下さい。

    $ mysqladmin version

    UNIX socket		/opt/local/var/run/mysql5/mysqld.sock

/usr/local/php5/lib/php.iniを編集して、調べた位置を指定して下さい。

    pdo_mysql.default_socket= /opt/local/var/run/mysql5/mysqld.sock
    mysql.default_socket = /opt/local/var/run/mysql5/mysqld.sock
    mysqli.default_socket = /opt/local/var/run/mysql5/mysqld.sock

## mysql接続確認 

以下をコンソールから実行してエラーが出なければ問題ありません。

    $ php -r 'mysql_connect("/path/to/mysqld.sock", "root", "");'; 
    $ php -r 'new mysqli("localhost", "root", "", "mysql");'
    $ php -r 'new PDO("mysql:host# localhost;dbnamemysql", "root", "");'

※/path/to/mysqld.sockは適宜変更してください。macportsでMySQLをインストールしている場合は/opt/local/var/run/mysql5/mysqld.sockです。

※トラブルシューティング：コンソールからのmysql接続がエラーになる場合は、前述「mysql用ソケットファイルの指定」で行った php.ini の設定内容が正しいかどうか、確認して下さい。