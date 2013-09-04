#summary FAQ
# インストールでの問題 

## ext-curl 
エラー表示
{{{
  Problem 1
    - The requested PHP extension ext-curl * is missing from your system.
}}}

cURLが必要です。

Ubuntuインストール例)
{{{
sudo apt-get install php5-curl
}}}
## svn 
エラー表示
{{{
[RuntimeException]                                      
  Package could not be downloaded, sh: 1: svn: not found
}}}

SVNがありません。インストールします。インストール時のみ必要です。

Ubunutuインストール例)
{{{
$ sudo apt-get install subversion"
}}}

 * `PHP Fatal error:  Uncaught exception 'Zend\Cache\Exception\ExtensionNotLoadedException' with message 'ext/apc is disabled - see 'apc.enabled' and 'apc.enable_cli''`

APCをオンにします。


## MySQL 

 * `PDOException: SQLSTATE[HY000] [2002] No such file or directory`

ソケットファイルの場所が正しく指定されていません。`mysqladmin version`(OSXなら`mysqladmin5 version`）で表示されるソケットファイルの場所をPHPのiniファイルで指定します。

    $ mysqladmin version
    UNIX socket		/opt/local/var/run/mysql5/mysqld.sock


※/opt/local/var/run/mysql5/mysqld.sockはmacportsでmysqlをインストールしている場合です。

    pdo_mysql.default_socket= /opt/local/var/run/mysql5/mysqld.sock
    mysql.default_socket = /opt/local/var/run/mysql5/mysqld.sock
    mysqli.default_socket = /opt/local/var/run/mysql5/mysqld.sock

# ランタイムでの問題 
## アノテーション 
### `[Semantical Error] The annotation` 例外 

これはアノテーションクラスが不明という例外です。

アノテーションの読み込みに失敗するのはオートロードが効いてないか、use文で名前解決ができてないためです。※doctrineアノーテション用オートロードは通常のクラスローダーと区別されます。


解決策
 * use文でimportする。
 * アプリケーションbootの箇所(App.php等)で手動でアノテーションクラスを読み込む、または [オートローダーを設定する](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html)
 * フルパスでアノテーションを指定する