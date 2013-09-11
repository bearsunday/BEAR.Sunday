---
layout: default
title: BEAR.Sunday | My First Web API
category: My First - Tutorial
--- 
# My First Web API 

Lets use the resource we made in [my_first_resource My First Resource] as a Web API.

Start the built in web server for the API.

```
$ cd apps/Sandbox/htdocs
$ php -S localhost:8099 api.php
```

We can then access it through a browser.

```
http://localhost:8089/first/greeting?name=BEAR
```

Did the greeting come back as JSON data?

In this way the resource you created can be used as a Web API.
If you run a web server like apache you can have people from across the world use your resource as a web api.