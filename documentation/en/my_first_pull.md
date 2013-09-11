---
layout: default
title: BEAR.Sunday | My First Pull
category: My First - Tutorial
--- 
# My First Pull

## Let's try calling a resource from a template  

Lets use a resource directly from a view(PHP Script).
When you directly use the greeting resource that we made before from HTML you do so like this.

```
<?php
$app = require dirname(dirname(__DIR__)) . '/scripts/instance.php';
$message # $app->resource->get->uri('app://self/first/greeting')->withQuery(['name' > 'BEAR'])->eager->request()->body;
?>
<html>
    <body><?php echo $message;?></body>
</html>
```

This *Plain PHP Script* is open directly in the web document domain, the web client receives the request directly.

The application object is retrieved from a script, then you can use that resource client to retrieve the application resource.

 Note: $app is a resource client and dependency injector needed for application control. For HTTP output and the like it has functionality that is key to the application. 

This shows how through this small script all information in BEAR.Sunday as a resource can easily be used.

## How is this any Different to What We Have Already 

Until now we have used resources from either the web or command line.
We have checked the resource as an API from the command line or used as a Web API.
Also a page is accessed from the web and viewed as a web page.

In both cases there has been a front script and from there the resource is requested and output.

Differently the resource consumed directly by this script.

## Is this any good? 

In MVC terms this is like the model being retrieved from the view.
Is the sequence not opposite? Is this right? The design and logic mixed, can't you even say this is bad code?

## Pull Based Architecture 

When from the view layer you trigger any processing, according to your needs you 'pull' the result it is called [http://en.wikipedia.org/wiki/Web_application_framework#Push-based_vs._pull-based Pull Based Architecture].

Many web MVC frameworks use the opposite 'Push' .
Execute the action which requests a process, next 'Pushing' the result to the view layer so that the data can be output. 
'Pull' is the opposite.

 Note: In [http://en.wikipedia.org/wiki/Comparison_of_web_application_frameworks Comparison of web application frameworks] we can see many different frameworks and whether they use PUSH/PULL.

Again BEAR.Sunday's 'resource pull' pulls resources using PHP code, however logic like domain logic or controller logic is not mixed up in the view.
In reality the resource is only being bound to the resource placeholder (`<?php echo $message;?>`).

## Use the API as a Resource 

This PHP script is uses the BEAR.Sunday framework, but it is not being used by any thing else. So through the script you are directly calling the resource for use.

In that just retrieving the resource client and making a request.
With no preparation at all you just use the resource.
You are not using HTTP as a mediator, as an API you can use resources in any other CMS or framework.
 
 Note: Using HTTP you can use many different frameworks from many other languages like [Thrift](http://thrift.apache.org/) for even more portability. 
 Document DB, client side MVC, mobile devices, SNS applications etc... Now more than any there is are huge reasons for building a core API application to support a large diversity of applications.