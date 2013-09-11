---
layout: default
title: BEAR.Sunday | My First Test
category: My First - Tutorial
--- 

# My First Test

## Resource Test 

Let's test the greeting resource that we made in [my_first_resource My First Resource].

## Test File Arrangement 

Lets create the test file structure. In relation to the greeting file it will look like the following.

|| Resource File || `apps/Sandbox/Resource/App/First/Greeting.php` ||
|| Test File　|| `apps/Sandbox/tests/Resource/App/First/GreetingTest.php` ||

## Creating The Test Class File 

We will save the class as `apps/Sandbox/tests/Resource/App/First/GreetingTest.php`.

```
<?php
namespace Sandbox\tests\Resource\App\Blog;

use Sandbox\Module\TestModule;
use Ray\Di\Injector;

class GreetingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Resource client
     *
     * @var BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        if (! $this->resource) {
            $injector = Injector::create([new TestModule]);
            $this->resource = $injector->getInstance('BEAR\Resource\ResourceInterface');
        }
    }

    /**
     * resource
     *
     * @test
     */
    public function resource()
    {
        // resource request
        $resource # $this->resource->get->uri('app://self/first/greeting')->withQuery(['name' > 'BEAR'])->eager->request();
        $this->assertSame(200, $resource->code);

        return $resource;
    }

    /**
     * Type ?
     *
     * @depends resource
     * @test
     */
    public function type($resource)
    {
        $this->assertInternalType('string', $resource->body);
    }

    /**
     * Renderable ?
     *
     * @depends resource
     * test
     */
    public function render($resource)
    {
        $html = (string)$resource;
        $this->assertInternalType('string', $html);
    }

    /**
     * @depends resource
     * @test
     */
    public function body($resource)
    {
        $this->assertSame('Hello, BEAR', $resource->body);
    }
}
```

## Let's Run the Tests　


We navigate to the application directory.

```
cd apps/Sandbox/
```

And run the tests.
```
phpunit tests/Resource/App/First/GreetingTest.php
```

```
...

Time: 2 seconds, Memory: 10.00Mb

OK (3 tests, 3 assertions)

Generating code coverage report in Clover XML format ... done

Generating code coverage report in HTML format ... done
```
We did it!

### Coverage Report 

In `build/coverage/index.html` we can see the scope of the tests covered.

## Let's Look At The Test Code 

### setup() 
```
$injector = Injector::create([new TestModule]);
$app = $injector->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
$this->resource = $app->resource;
```

We create an injector in the test class setup method, with that interceptor we grab the application object.
In the test the application object uses the resource client stored in a property.

### resource() 
```
$resource # $this->resource->get->uri('app://self/first/greeting')->withQuery(['name' > 'BEAR'])->eager->request();

```
We use the resource client inside the resource() method to access the resource.

### Other Test Methods 
In other `@test` annotated methods we check the results received through the resource method.