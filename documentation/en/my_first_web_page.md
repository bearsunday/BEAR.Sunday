---
layout: default
title: BEAR.Sunday | My First Web Page
category: My First - Tutorial
---

# Lets Create A Web Page 

## Page Resource 

First without using an application resource, we will make the most basic page class possible.
(without using a model and only using a controller to create a 'Hello World' page)

## Starting from the Most Basic of Pages 

Just like application resource creates the instance of a resource, 
a page resource can also create an instance of a page resource.

The greeting 'Hello' is fixed in a static page.

```
<?php
namespace Sandbox\Resource\Page\First;

use BEAR\Resource\AbstractPage as Page;

/**
 * Greeting page
 */
class Greeting extends Page
{    
    public $body = [
        'greeting' => 'Hello.'
    ];

    public function onGet()
    {
        return $this;
    }
}
```

We store the string 'Hello.' in the page contents 'greeting' slot. 
When the get request is called it does nothing but return itself.

## Lets Check the Page Resource State from the Command Line 

Lets check this resource from the command line.

```
$ cd apps/Sandbox/htdocs/
$ php api.php get page://self/first/greeting

200 OK
...
[BODY]
greeting:Hello.
```

We have confirmed that in the greeting slot the string 'Hello' exists.

## Render the Page Resource State 

In order to render the state of the page resource as HTML we need a template. 
We save this in the same place as the resource and just change the suffix.

### File Path 

|| URI || `page://self/first/greeting` ||
|| Resource Class || `apps/Sandbox/Resource/Page/First/Greeting.php` ||
|| Resource Template || `apps/Sandbox/Resource/Page/First/Greeting.tpl` ||


### Template 
```
<!DOCTYPE html>
<html lang="en">
  <body>
      <h1>{$greeting}</h1>
  </body>
</html>
```
## Check the HTML from the Command Line 

We assign the resource state to the template and the resource renders as HTML.
This is a HTML page and can also be checked via the command line.

Lets check.

```
$ php web.php get /first/greeting
```
```
200 OK
cache-control: ["no-cache"]
date: ["Fri, 01 Feb 2013 14:21:45 GMT"]
[BODY]
<!DOCTYPE html>
<html lang="en">
<body>
<h1>Hello, anonymous</h1>
</body>
</html>
```
HTML all checked!

 Note: Because we are running the development environment, there are many headers prepended by `x-` that contain useful development information. 

## Checking the Page HTML in a Web Browser 

```
http://localhost:8088/first/greeting
```

Did you see the page OK?

## Role of the Page 

A page gathers clusters of information (resource), and configures the page itself.
Here a singular slot 'greeting' has the string 'Hello' stored in it, however many pages will need multiple slots.

The pages role is to configure the page to gather other resources and to solidify the pages state. 
The resource state is composed with the resource template and rendered as HTML to be passed and shown to the user.