---
layout: default_ja
title: BEAR.Sunday | blogチュートリアル(8) 記事の削除
category: ブログ・チュートリアル
---
# blogチュートリアル(8) 記事の削除

## 記事ページの削除 

記事ページからid指定した記事を削除できるように、記事ページリソースにonDelete()メソッドを作成しDELETEリクエストに対応します。

    /**
     * Delte
     * 
     * @param int $id
     */
    public function onDelete($id)
    {
        // delete
        $this->resource
        ->delete
        ->uri('app://self/posts')
        ->withQuery(['id' => $id])
        ->eager
        ->request();
        
        // message
        $this['message'] = 'Entry deleted.';
        return $this->onGet();
    }

webブラウザからのDELETEリクエストを受け取ったページリソースは記事リソースを同じようにDELETEリクエストしています。

この記事ページリソースへのリンクは記事リソースのテンプレートに記述します。Javascriptを使って確認ダイアログを出し、ページリクエストを`DELETE`にするために`_method`クエリーを使っています。

  Note: POSTの時にフォームに`X-HTTP-Method-Override`hiddenエレメントを埋め込んだり、GETクエリーで`_method`を使ったりするのは_HTTPメソッドオーバーライド_という方法でPUT/DELETEのサポートがないブラウザやサーバー環境でHTTP動詞をフルに使う為の仕組みです。

## 記事リソースのDELETEインターフェイスの作成 

記事ページからリクエストを受け取った記事リソースがDBアクセスで記事を削除します。

    public function onDelete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
        $this->code = 204;
        return $this;
    }

  Note: GETリクエストインターフェイスと同じく`$this->db`プロパティはインジェクターによって自動でセットされます。GETの時と違うのはmasterDB用の接続が使われる事です。


## コマンドで確認
ではコンソールで試してみましょう。codeに204を指定したのでこのような表示になるはずです。

    $ php api.php delete app://self/posts?id=1
    204 No Content
    [BODY]

## ユニットテスト 

DELETEアクセスすると記事が１つ減っているはずです。テストはこのようなものになるでしょう。

    /**
     * @test
     */
    public function delete()
    {
        // dec 1
        $before = $this->getConnection()->getRowCount('posts');
        $response = $this->resource
        ->delete
        ->uri('app://self/posts')
        ->withQuery(['id' => 1])
        ->eager
        ->request();
        $this->assertEquals($before - 1, $this->getConnection()->getRowCount('posts'), "faild to delete post");
    }

## 確認ダイアログJS

削除の確認をするためにsandboxアプリケーションが持つJSライブラリを利用しています。


    <a title# "Delete post" class="btn" href="#" onclick="return MyDialogs.loadConfirmationModal('my_dialog', '/blog/posts?_method=delete&id={$post.id}', 'Are you sure ?', 'The entry will be deleted permanently.');"><span class"icon-trash"></span></a>