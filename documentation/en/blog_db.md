---
layout: default
title: BEAR.Sunday | Blog Tutorial(2) Database Settings
category: Blog Tutorial
---

# Database 

## Before you start 

Follow the [install#DB Installation] DB section and enable your DB, then run the test code.

## Checking 
With the following code you can check the database connection is reading records.

```
php -r '$pdo# new PDO("mysql:host=localhost;dbnameblogbear", "root", "");foreach($pdo->query("SELECT * from posts") as $row){print_r($row);}'
```