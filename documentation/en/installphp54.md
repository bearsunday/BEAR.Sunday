---
layout: default
title: BEAR.Sunday | PHP5.4 Installation
category: Installation
---
# PHP5.4 Installation

This is an example of how to build a PHP5.4 environment on OSX. In this example we will perform a PHP binary install from [http://php-osx.liip.ch/](http://php-osx.liip.ch/). The extensions we need will also be installed. We will be using `/usr/local/php5`, no other directories will be affected.

## PHP Install 

We enter the following from a console.

```
$ curl -s http://php-osx.liip.ch/install.sh | bash -s 5.4
```

We check the version.

```
$ /usr/local/php5/bin/php -v

PHP 5.4.2 (cli) (built: May  8 2012 09:48:57) 
Copyright (c) 1997-2012 The PHP Group
Zend Engine v2.4.0, Copyright (c) 1998-2012 Zend Technologies
    with Xdebug v2.2.0rc2, Copyright (c) 2002-2012, by Derick Rethans
```

## Edit the ini File 

Check the location of the ini file.
```
$ php --ini
```

Edit apc.ini and xhprof.ini.

/usr/local/php5/php.d/50-extension-apc.ini
```
extension=/usr/local/php5/lib/php/extensions/no-debug-non-zts-20100525/apc.so
apc.enable_cli = on
```

/usr/local/php5/php.d/50-extension-xhprof.ini
```
xhprof.output_dir = /tmp
```

## Install MySQL 
From [http://dev.mysql.com/downloads/mysql/ Download MySQL Community Server] download the DMG gile and install.

## Apache 
Use the default version.

### Set the Mysql Socket File 

MySQLを上記のDMGインストールでインストールしているなら、この指定は不要です。 macports等でmysqlをインストールしている場合は、下記のように指定する必要があります。
If you have installed MySql from the DMG installer above the this setting is no needed. If you have installed MySql from MacPorts or the like you will need settings as below.

Find the socket file using the mysqladmin command.

```
$ mysqladmin version

UNIX socket     /opt/local/var/run/mysql5/mysqld.sock
```

Edit /usr/local/php5/lib/php.ini to include this file location as below.

```
pdo_mysql.default_socket= /opt/local/var/run/mysql5/mysqld.sock
mysql.default_socket = /opt/local/var/run/mysql5/mysqld.sock
mysqli.default_socket = /opt/local/var/run/mysql5/mysqld.sock
```

## Check MySql Connection 

If you run the following from a console and see no errors then you are good.
```
$ php -r 'mysql_connect("/path/to/mysqld.sock", "root", "");'; 
$ php -r 'new mysqli("localhost", "root", "", "mysql");'
$ php -r 'new PDO("mysql:host# localhost;dbnamemysql", "root", "");'
```

※ Please appropriatly change /path/to/mysqld.sock. If you have installed using MacPorts it will be /opt/local/var/run/mysql5/mysqld.sock.

※ Troubleshooting: From the console if you receive MySql Connection errors, please check that *MySql socket file setting* in php.ini has been entered correctly or not.