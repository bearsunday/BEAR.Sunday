---
layout: default
title: BEAR.Sunday | BEAR.Sunday Ubuntu 12LTS setup form ZERO
category: Installation
---
#summary Installation

# Installation 

```
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar create-project -s dev --dev bear/package ./bear
```

## Prerequisites 
 * PHP 5.4
 * [APC](http://php.net/manual/ja/book.apc.php)
 * [curl](http://php.net/manual/ja/book.curl.php)

 For APC PHP5.4 support please [http://jp.php.net/manual/ja/apc.setup.php install > v3.1.10]
 
## Optional 
 * Profiler　[xhprof](http://jp.php.net/manual/en/book.xhprof.php)
 * Graph Visualization [graphviz](http://www.graphviz.org/)

## Environment Check 
```
$ php bin/env.php
```
Tests a correct php.ini and DB connection.

### DB Connection Check 

If you have trouble connecting to the db please try entering the following in a console.

```
$ php -r 'new mysqli("localhost", "root", "", "mysql");'
$ php -r 'new PDO("mysql:host# localhost;dbnamemysql", "root", "");'
```

    ※ When set up with root/(no password)

## DB 

When you can connect to `localhost` with `root/(no password)` no further settings are needed.
Otherwise there are 2 ways to add your database connection settings.

### 1) Environment Variables


So that PHP can read your environment variables set the following in php.ini

|| BEAR_DB_ID || ID || 
|| BEAR_DB_PASSWORD || Password ||

Optional slave DB setting is available.

|| BEAR_DB_ID_SLAVE || (SLAVE DB) ID || 
|| BEAR_DB_PASSWORD_SLAVE || (SLAVE DB) Password ||

Example) Exporting with ~/.bashrc using environment variables "root" / "password".

~/.bashrc content

```
export BEAR_DB_ID=root
export BEAR_DB_PASSWORD=password
```

Export with ~/.bashrc
```
. ~/.bashrc
```


### 2) PHP File Configuration =

Edit `apps/Sandbox/Module/config.php` to directly set your configuration.

# Unit Tests 
## Test Environment 

```
$ pear config-set auto_discover 1
$ pear install pear.phpunit.de/PHPUnit
$ pear install phpunit/DbUnit
$ pear install phpunit/PHP_Invoker
```
 Note: Depending on your environment you may need to run as root user.

## DB Setup 
In order to run tests, you need to create the db for the tests and sandbox application.

Run the shell script or enter manually.

### Using the shell script 
$ apps/Sandbox/scripts/install_db.sh

### Manually 

Create the `blogbear` Database

```
CREATE DATABASE `blogbear` DEFAULT CHARACTER SET 'utf8';
```

Create the posts table
```
CREATE TABLE posts (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(50),
body TEXT,
created DATETIME DEFAULT NULL,
modified DATETIME DEFAULT NULL
);
/* Now add the test posts. */
INSERT INTO posts (title,body,created)
VALUES ('Title', 'This is the post text.', NOW());
INSERT INTO posts (title,body,created)
VALUES ('Another Title', 'Here the text continues', NOW());
INSERT INTO posts (title,body,created)
VALUES ('Yet another title', 'This looks super amazing！Not..', NOW());
```

### Unit test database setting 
Content will be populated in setup and torn down automatically so there is no need to prepare test data. 

```
CREATE DATABASE `blogbeartest` DEFAULT CHARACTER SET 'utf8';
```
```
CREATE TABLE posts (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(50),
body TEXT,
created DATETIME DEFAULT NULL,
modified DATETIME DEFAULT NULL
);
```



# Running tests 
$ phpunit

# Running the sandbox application 

BEAR.Sunday application can be accessed via the web or CLI.
Please see https://github.com/koriym/BEAR.package#buil-in-web-server-for-development.


## Troubleshooting 
Please see the [faq FAQ].