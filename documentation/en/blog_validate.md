---
layout: default
title: BEAR.Sunday | Blog Tutorial(5) Validation
category: Blog Tutorial
---

# Form 

In the previous section we implemented the POST interface in the posts add page, we were then able to add posts by receiving a HTTP mtethod.

Next we will add to the POST interface validation, folder, pre populated fields on error functionality as a web form.

 Note: In this tutorial we won't use any special libraries we will just code in plain PHP. In reality it might be better to use a validation library that is part of Zend Framework or Symfony.

## Validation 

We will implement a form interceptor that doesn't depend on a specific library. First we will bind the form validation interceptor and the `@Form` annotation.

Annotation sandbox\Annotation\Form

```
namespace Sandbox\Annotation;

/**
 * Form
 *
 * @Annotation
 * @Target({"METHOD"})
 */
final class Form
{
}
```

Interceptor binding
```
    /**
     * @Form - bind form validator
     */
    private function installFormValidator()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Sandbox\Resource\Page\Blog\Posts\Newpost'),
       	    $this->matcher->annotatedWith('sandbox\Annotation\Form'),
            [new PostsFormValidator]
        );
    }
```

In this case the `PostsFormValidator` is bound to methods annotated with `@Form`. Before the request calls the POST method this validation interceptor is called.

## @Form Validation Interceptor 

In the interceptor that is　wedged between the request and the method, after the tag removal process is when the validation happens. 
```
return $invocation->proceed();
```
If the validation fails then the *processing GET request page* that shows an error message and preset values etc is output. The POST interface method will not be called.

```
return $page->onGet();
```

When this is all wrapped up in the `PostsFormValidator` it looks like this.
```
/**
 * Log Interceptor
 */
class PostsFormValidator implements MethodInterceptor
{
	const TITLE = 0;
	const BODY = 1;
	
	/**
	 * Error
	 * 
	 * @var array
	 */
	private $errors = [
		'title' => '',
		'body' => ''
	];
	
    /**
     * (non-PHPdoc)
     * @see Ray\Aop.MethodInterceptor::invoke()
     */
    public function invoke(MethodInvocation $invocation)
    {
        // retrieve page and query
    	$args = $invocation->getArguments();
    	$page = $invocation->getThis();
    	
    	// strip tags
    	foreach ($args as &$arg) {
    		$arg = strip_tags($arg);
    	}
    	
    	// required title
    	if ($args[self::TITLE] # = '') {
    		$this->errors['title'] = 'title required.';
    	}
    	
    	// required body
    	if ($args[self::BODY] # = '') {
    		$this->errors['body'] = 'body required.';
    	}
    	
    	// valid form ?
    	if (implode('', $this->errors) # = '') {
	    	return $invocation->proceed();
    	}
    	
        // error, modify 'GET' page with error message.
    	$page['errors'] = $this->errors;
    	$page['submit'] =[
    		'title' => $args[self::TITLE],
    		'body' => $args[self::BODY]
    	];
    	return $page->onGet();
    }
}
```

[MethodInterceptor](https://github.com/koriym/Ray.Aop/blob/master/src/Ray/Aop/MethodInterceptor.php) which conforms to the [http://aopalliance.sourceforge.net/ AOP Alliance]. The `$invocation` object passed to the `invoke` method is as it suggests method invoking object of the `MethodInvocation` type.

The parameters at the time the method can be obtained by calling `$invocation->getArguments()` and  
the original page display resource object can be obtained by calling `$invocation->getThis();`.

 Note: The parameters are not in the named parameters style, they are the ordered style that can normally be picked up in the method call.