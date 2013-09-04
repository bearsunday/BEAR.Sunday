---
layout: default_ja
title: BEAR.Sunday | Ubuntu設定
category: インストールと設定
---
# Ubuntu設定 

UbuntuでPHP環境を整えるところから初めてBEAR.Sundayをインストールします。"sunday.local"をホスト名にしたVirtual Hostを設定しています。

アクセスするときはhostsファイルをそのサーバーに向けアクセスします。Ubuntu 12LTSをVmware / Amazon EC2で確認しています。


    127.0.0.1 sunday.local


# Details 

```
# become root
sudo -s

# Ubuntu11の場合 (PHP5.4にするため) / Ubuntu12では不要
apt-get install python-software-properties
add-apt-repository ppa:ondrej/php5

# initial updates
aptitude update
aptitude dist-upgrade -y

# apache2, php, git, svn, mysql, make, graphviz

aptitude install -y \
    apache2-mpm-prefork \
    libapache2-mod-php5 \
    php-apc \
    php5-cli \
    php5-common \
    php5-dev \
    php5-curl \
    php5-mysqlnd \
    php5-xdebug \
    php5-dev \
    php-pear \
    git-all \
    mysql-server \
    mysql-client \
    subversion \
    make \
    graphviz

# facebook/xhprof
git clone git://github.com/facebook/xhprof.git
cd xhprof/extension
phpize
./configure 
make
sudo make install

# modify the Apache DocumentRoot for the BEAR.Suday using vhost_alias.

cd /etc/apache2/sites-available/
sed -i "s~</VirtualHost>~\
\n        ServerName localhost \
\n        VirtualDocumentRoot /var/www/%0/public \
\n</VirtualHost>~" default
sed -i "s/AllowOverride None/AllowOverride All/" default

# Apache module
a2enmod rewrite vhost_alias

# BEAR.Sunday install

curl -s https://getcomposer.org/installer | php
rm -rf /var/www
midir -p /var/www
php composer.phar create-project -s dev --dev bear/package /var/www/sunday.local
/var/www/sunday.local/apps/Sandbox/scripts/install_db.sh

# php.ini
echo -e "apc.enable_cli# on\nxhprof.output_dir  /tmp" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

# bug ?
ln -s /usr/lib/php5/20100525 /usr/lib/php5/20090626

# check install
php bin/env.php

# restart apache
/etc/init.d/apache2 restart
```