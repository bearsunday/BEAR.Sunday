---
layout: default_ja
title: BEAR.Sunday | はじめてのテスト
category: 「はじめての」チュートリアル
---

# はじめてのテスト

## リソーステスト 

[my_first_resource はじめてのリソース]で作成した挨拶リソーステストします。

## テストファイルの配置場所 

テストファイルを配置します。リソースファイルとの場所はこのようになります。

|| リソースファイル || `apps/Sandbox/Resource/App/First/Greeting.php` ||
|| テストファイル　|| `apps/Sandbox/tests/Resource/App/First/GreetingTest.php` ||

## テストクラスファイルを作成します 

このクラスを`apps/Sandbox/tests/Resource/App/First/GreetingTest.php`として保存します。

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

## テストを実行してみましょう　

アプリケーションディレクトリに移動します。

```
cd apps/Sandbox/
```

テスト実行します。
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
OKでました！

### カバレッジレポート 

`build/coverage/index.html`にはどの範囲のコードが今のテストでカバーできたら確認することができます。

## テストコードをみてみましょう 

### setup() 
```
$injector = Injector::create([new TestModule]);
$app = $injector->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
$this->resource = $app->resource;
```

テスト用のモジュール（設定）でインジェクターを作成し、そのインジェクターでアプリケーションオブジェクトを取得しています。テストではアプリケーションオブジェクトはプロパティにあるリソースクライアントを利用します。


### resource() 
```
$resource # $this->resource->get->uri('app://self/first/greeting')->withQuery(['name' > 'BEAR'])->eager->request();

```
resource()メソッド内ではリソースクライアントを使ってリソースをアクセスしています。

### その他のテストメソッド 
その他の`@test`とアノテートされたメソッドでは`resource()`で得られた結果をチェックしています。