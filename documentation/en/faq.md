---
layout: default
title: BEAR.Sunday | FAQ)
category: Others
---

# FAQ

# Problems with Installation 

## ext-curl 
Error displayed
```
  Problem 1
    - The requested PHP extension ext-curl * is missing from your system.
```

You need cURL installed.

Ubuntu installation example)
```
sudo apt-get install php5-curl
```
## svn 
Error displayed
```
[RuntimeException]                                      
  Package could not be downloaded, sh: 1: svn: not found
```

You need SVN installed.

Ubuntu installation example)
```
$ sudo apt-get install subversion"
```

 * `PHP Fatal error:  Uncaught exception 'Zend\Cache\Exception\ExtensionNotLoadedException' with message 'ext/apc is disabled - see 'apc.enabled' and 'apc.enable_cli''`

APC needs to be enabled.

## MySQL 

 * `PDOException: SQLSTATE[HY000] [2002] No such file or directory`

The socket file location has not been correctly set. Set the PHP ini file using the socket file location which is shown  using `mysqladmin version` (OSX - `mysqladmin5 version`)

```
$ mysqladmin version

UNIX socket		/opt/local/var/run/mysql5/mysqld.sock
```

* When mysql is installed with macports /opt/local/var/run/mysql5/mysqld.sock

```
pdo_mysql.default_socket= /opt/local/var/run/mysql5/mysqld.sock
mysql.default_socket = /opt/local/var/run/mysql5/mysqld.sock
mysqli.default_socket = /opt/local/var/run/mysql5/mysqld.sock
```

# Runtime Problems 
## Annotations 
### `Semantical Error` annotation Exception 

This is an exception when the annotation class is unknown.

If there are problems in reading annotations then either the auto-loader is having problems or the `use` naming resolution is has not worked. ※The class loader used for Doctrine annotations is separate.

Resolution
 * Import using `use`. 
 * In the application boot location (App.php etc) manually import the annotation class or [http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html setup the autoloader].
 * Set annotations using their full path.