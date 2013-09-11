---
layout: default
title: BEAR.Sunday | My First Hypermedia
category: My First - Tutorial
--- 

# Hypermedia 

## What is Hypermedia? 

In 1962 Ted Nelson proposed [Hypertext](http://en.wikipedia.org/wiki/Hypertext)`.
This is when in order to refer some text other text referral links are embedded in the text itself, the referrals that joins the text are called Hyperlinks.

The most famous and successful implementation of Hypertext is the Worldwide Web.

(The href in a property of the `<a>` tag is an abbreviation for hyper-reference).
Also to note is that PHP is an acronym of *PHP: Hypertext Preprocessor* ([http://www.php.net/manual/en/faq.general.php#faq.general.acronym PHP an acronym for what?])

## Non Existent Hypermedia 

Let's think in terms of a `REST API` for example when you order a coffee at a coffee shop.

When you order a coffee, the `REST API` is provided with the following.

|| METHOD || POST ||
|| URI || `http://restbucks.com/order/{?drink}` ||
|| Query || drink=Drink Name ||

You use this `API` when ordering a drink. When using this API you create a (POST) `Order Resource`.

```
post http://restbucks.com/order/?drink=latte
```

The order resource has been created and the order contents are returned.

```
{
    "drink": "latte",
    "cost": 2.5,
    "id": "5052",
}
```

This is *not hypermedia*. The data does not have any attached uniquely displayed URI's or related links.

## HAL - Hypertext Application Language 

JSON is not essentially a hypermedia format, however using JSON the 
[http://stateless.co/hal_specification.html HAL - Hypertext Application Language]
which is a [http://tools.ietf.org/html/draft-kelly-json-hal-00 RFC Draft Standard] 
is used to provide `JSON+HAL` hyper-media.

In BEAR.Sunday when you set your resource rendering to `HalRenderer` you can output in HAL format.

```
{
    "drink": "latte",
    "cost": 2.5,
    "id": "1545",
    "_links": {
        "self": {
            "href": "app://self/restbucks/order?id=1545"
        },
        "payment": {
            "href": "app://self/restbucks/payment?id=1545"
        }
    }
}
```

This is an order resource output in the `HAL` Format.
The URI's and related link information for itself are embedded in the `_links` property.
The order and payment relationship is not saved by the client, but by the service.

On the service side you can change the link references according to service circumstances.
In those times you need to change nothing on the client, just carry on following the provided link.
By having links you transform your service from just another data format to a self descriptive Hyper-Media resource.

## Adding Hyperlinks 

You declare your resource object's `links` property like this. 

```
    public $links = [
        'news' # > [Link::HREF > 'page://self/news/today']
    ];
```

## Using a URI Template for your Query 

When the URI to dynamically decided you can for example you can create a query in the onPost method like this.
```
$this->links['friend'] # [Link::HREF => "app://self/sns/friend?id{$id}"];
```

In the `links` property you can set the URI template like this.

```
    public $links => [
        'friend' # > [Link::HREF => 'app://self/sns/friend{?id}', Link::TEMPLATED > true]
    ];
```

Here the necessary variable `{id}` is retrieved from the resource `body`.

## Lets Try 

Here is the class that assigns `$item` and creates the order resource.

```
<?php
namespace Sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Resource\Link;

/**
 * Greeting resource
 */
class Order extends AbstractObject
{
    public function onPost($item)
    {
        $this['item'] = $item;
        $this['id'] = date('is'); // min+sec

        return $this;
    }
}

```

In order to add hyperlinks setup the `links` property.
```
    public $links = [
        'payment' # > [Link::HREF => 'app:/self/first/hypermedia/payment{?id}', Link::TEMPLATED > true]
    ];
```

## Make API Request From the Console  

```
$ api get app://self/first/hypermedia/user?id=1
```
```
200 OK
content-type: application/hal+json; charset=UTF-8
[BODY]
{
    "item": "book",
    "id": "1442",
    "_links": {
        "self": {
            "href": "app://self/first/hypermedia/order?item=book"
        },
        "payment": {
            "href": "app:/self/first/hypermedia/payment{?id}",
            "templated": true
        }
    }
}
```

The `payment` link now appears.

## Using Links in a Program 

In order to use links in your code, inject the `A` object using the trait `AInject` and use the `href` method to retrieve links.
The resource body can retrieve the link composed by the URI template.
```
<?php
namespace Sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Inject\AInject;
/**
 * Greeting resource
 */
class Shop extends AbstractObject
{
    use ResourceInject;
    use AInject;

    public function onPost($item, $card_no)
    {
        $order = $this
        ->resource
        ->post
        ->uri('app://self/first/hypermedia/order')
        ->withQuery(['item' => $item])
        ->eager
        ->request();

        $payment = $this->a->href('payment', $order);

        $this
        ->resource
        ->put
        ->uri($payment)
        ->withQuery(['card_no' => $card_no])
        ->request();

        $this->code = 204;
        return $this;
    }
}
```
Just like on a web page and you just click a link to go on to the next page, you are now able to control the next links in the service layer.
Even when the links change there is no need for any change in the client.