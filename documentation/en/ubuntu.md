---
layout: default
title: BEAR.Sunday | BEAR.Sunday Ubuntu 12LTS setup form ZERO
category: Installation
---

# BEAR.Sunday Ubuntu 12LTS setup form ZERO 

We will start by getting our PHP environment in order then install BEAR.Sunday for the first time. We will set up a virtual host with the name "sunday.local".

We will point the hosts file to the server that we are accessing. We will heck it on Ubuntu 12LTS on Vmware / Amazon EC2.

```
127.0.0.1 sunday.local
```

# Details 

```
# become root
sudo -s

# initial updates
apt-get install python-software-properties
add-apt-repository ppa:ondrej/php5
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
\n        VirtualDocumentRoot /var/www/%0/htdocs \
\n</VirtualHost>~" default
sed -i "s/AllowOverride None/AllowOverride All/" default

# Apache module
a2enmod rewrite vhost_alias

# BEAR.Sunday install
cd /
rm -rf /var/www
git clone https://github.com/koriym/BEAR.Package.git /var/www/sunday.local
cd /var/www/sunday.local
ln -s apps/Sandbox/public htdocs
chmod -R 777 apps
wget http://getcomposer.org/composer.phar
php composer.phar install
apps/Sandbox/scripts/install_db.sh

# php.ini
echo -e "apc.enable_cli# on\nxhprof.output_dir  /tmp" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

# bug ?
ln -s /usr/lib/php5/20100525 /usr/lib/php5/20090626

# check install
php bin/env.php

# restart apache
/etc/init.d/apache2 restart

```