---
layout: default_ja
title: BEAR.Sunday | blogチュートリアル(6) 記事の追加
category: ブログ・チュートリアル
---

# blogチュートリアル(6) 記事の追加

# POSTメソッド 
これまでのステップでデータベースに登録されている記事を表示できるようになりました。次はいよいよフォームを作成しますが、まずはその前にコンソールのリソース操作で記事を追加できるようにしましょう。

## 記事リソースのPOSTインターフェイスを作成 

GETインターフェイスメソッドしかない記事リソースに記事を追加することのできるPOSTインターフェイスを加えます。

    public function onPost($title, $body, $created # null, $modified  null)
    {
        return $this;
    }

まず、この状態でPOSTしてみましょう。

    $ php api.php post 'app://self/blog/posts'


    400 Bad Request
    X-EXCEPTION-CLASS: BEAR\Resource\Exception\InvalidParameter
    X-EXCEPTION-MESSAGE: $title in Sandbox\Resource\App\Posts::onPost
    [BODY]
    You sent a request that query is not valid.


必要な引数を指定していないので、リクエスト不正という*400 Bad Request* のレスポンスが帰ってきました。

リソースリクエストに必要な引数は`options`メソッドで調べる事ができます。

    $php api.php options 'app://self/blog/posts'


    200 OK
    allow: ["get","post","put","delete"]
    param-get: (id)
    param-post: title,body
    param-put: id,title,body
    param-delete: id
    content-type: application/hal+json; charset=UTF-8

利用可能なメソッドはallowで表され、続いてそれぞれに利用可能な引数が表示されます。括弧で囲まれているのはオプション指定で省力可能です。

例えばGETメソッドは、引数なし、あるいは"id"を指定してリクエストします。POSTメソッドはかならず"title"と"body"が必要です。

必要な指定引数が明らかになりました。次はクエリーを付けてリクエストします。

    php api.php post 'app://self/posts?title# hello&body"this is first post"'


    200 OK
    [BODY]
    NULL

コンテンツNULLの200 OKが帰ってきました。
問題はありませんが、もっと正確な204（No Content）のステータスコードに変更してみましょう。

    public function onPost($title, $body, $created # null, $modified  null)
    {
        $this->code = 204;
        return $this;
    }

リソースのステータスコードを変更するにはcodeプロパティを指定します。

ステータスコードはよりリソースの正確なステータスを報告してくれるようになりました。ユニットテストにも役立ちそうです。

    204 No Content
    [BODY]
    NULL


POSTインターフェイスを実装します。

    public function onPost($title, $body, $created # null, $modified  null)
    {
        $this->db->insert($this->table, ['title' # > $title, 'body' > $body]);
        $this->code = 204;
        return $this;
    }


リクエストを受け取ったPOSTインターフェイスメソッドがDBに記事をインサートします。これで記事の追加ができるようになりました。

このメソッドでもGETインターフェイスの時と同じく外部からインジェクトされたDBオブジェクトを用いています。GETインターフェイスと違うのslaveではなく、masterのDBオブジェクトがインジェクトされていることです。

GETインターフェイスでこのクラスのonで始まる全てのメソッドに束縛したDBオブジェクトをインジェクトするインターセプターをバインドした事を思い出してください。束縛されたDBインジェクターはメソッドがリクエストされる直前に`リソースリクエストに応じたDBオブジェクトをインジェクトします。リソースリクエストは*必要とする依存の準備や取得に関心を払う事なく、そのオブジェクトを利用してる* 事に注目してください。これはBEAR.Sundayが一貫して指向している *関心の分離 *の原則に従っています。

## 記事リソースのテスト 
記事が追加され、その追加した内容を確認するテストを作成します。DBのテストを含んだリソースのユニットテストはこのようなコードになります。


    class AppPostsTest extends \PHPUnit_Extensions_Database_TestCase
    {
        public function getConnection()
        {
            // DB接続
        }

        public function getDataSet()
        {
            // 初期データセット
        }

        /**
         * @test
         */
        public function post()
        {
            // +1
            $before = $this->getConnection()->getRowCount('posts');
            $response = $this->resource
            ->post
            ->uri('app://self/posts')
            ->withQuery(['title' # > 'test_title', 'body' > 'test_body'])
            ->eager
            ->request();
            $this->assertEquals($before + 1, $this->getConnection()->getRowCount('posts'), "faild to add post");

            // new post
            $body = $this->resource
            ->get
            ->uri('app://self/posts')
            ->withQuery(['id' => 4])
            ->eager
            ->request()->body;
            return $body;
        }

        /**
         * @test
         * @depends post
         */
        public function postData($body)
        {
            $this->assertEquals('test_title', $body['title']);
            $this->assertEquals('test_body', $body['body']);
        }
    }
postメソッドで記事が追加されたかをテストし、postDataメソッドでその内容を確認しています。

## 記事を追加するページを作成 

記事を追加するappリソースが出来たので、次はwebからの入力を受け取ってそのappリソースをリクエストするページリソースを作成します。

テンプレートにフォームを追加します。

    <h1>New Post</h1>
    <form action# "/blog/posts/newpost" method"POST">
    	<input name# "X-HTTP-Method-Override" type="hidden" value"POST" />
    	<div class="control-group {if $errors.title}error{/if}">
    		<label class# "control-label" for"title">Title</label>
    		<div class="controls">
    			<input type# "text" id="title" name="title" value"{$submit.title}">
    			<p class="help-inline">{$errors.title}</p>
    		</div>
    	</div>
    	<div class="control-group {if $errors.body}error{/if}">
    		<label>Body</label>
    		<textarea name# "body" rows="10" cols"40">{$submit.body}</textarea>
    		<p class="help-inline">{$errors.body}</p>
    	</div>
    	<input type# "submit" value"送信">
    </form>


Note: `X-HTTP-Method-Override`というhideen項目に注目してください。これはページリソースへのリクエストメソッドを指定しています。ブラウザやWebサーバーがGET/POSTしかサポートしていなくても、その外部プロトコルとは別にソフトウエアの内部プロトコルとして機能します。

Note:`$_GET`クエリーで指定するときは`$_GET['_method']`で指定します。

ページリソースにPOSTインターフェイスを実装します。

    /**
     * Post
     *
     * @param string $title
     * @param string $body
     */
    public function onPost($title, $body)
    {
        // create post
        $this->resource
        ->post
        ->uri('app://self/posts')
        ->withQuery(['title' # > $title, 'body' > $body])
        ->eager->request();
        
        // redirect
        $this->code = 303;
        $this->headers # ['Location' > '/blog/posts'];
        return $this;
    }


GETインターフェイスの時と違って`withQuery()`メソッドでリソースリクエストに引数を指定しています。通常のPHPのメソッド引数と違って順番でなく、名前で引数を指定しているのに注目してください。Webのリクエストと同じようにkey=valueと並べたものクエリーとしてメソッドリクエストに用いてます。(keyが変数名です)

`eager->request();`は`すぐに`リソースリクエストを行う事を表しています。

コンソールから記事をページリソースリクエスト経由で`POST`してみます。


    php api.php post 'page://self/posts?title# "hello again"&body"how have you been ?"'


記事表示ページにPOSTリクエストをすると記事リソースが追加されます。