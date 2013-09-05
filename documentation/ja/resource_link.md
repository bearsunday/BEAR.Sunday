---
layout: default_ja
title: BEAR.Sunday | リソースリンク 
category: リソース
--- 

# リソースリンク 

リソースは他のリソースにリンクする事ができます。クライアントはリソースとリソースが実際にどのように接続されているかを知らずに、関係性（rel)を利用してリンクをたどる事ができます。

複雑なオブジェクトがオブジェクトグラフで現される様に、webサイトはhtml（リソース）とhtmlがaタグで繋がれたリソースグラフです。BEAR.Sundayでは、アプリケーションドメインのリソースがスキーマを超えて互いに接続されます。

リンクは`links`プロパティを使ってURIを直接指定する方法と、同じクラスのリンクメソッドを呼ぶ方法の二種類があります。

# リンクプロパティ 

リソースオブジェクトは`links`というプロパティにarrayまたは[ArrayAccess](http://php.net/manual/ja/class.arrayaccess.php)インターフェイスを実装したリンクオブジェクトで他のリソースへの接続情報を保持します。フォーマットは`$rel` # > ['href' > $uri];`が最低限必要なものです。

例えば`sandboxトップページリソース`は各ページのリンク情報をこのように持っています。

```
use BEAR\Framework\Resource\Link;

class Index extends Page
{
...
    /**
     * Links
     *
     * @var array
     */
    public $links = [
        'helloworld' # > [Link::HREF > 'page://self/hello/world'],
        'blog' # > [Link::HREF > 'page://self/blog/posts'],
        'restbucks' # > [Link::HREF > 'page://self/restbucks/index']
    ];
```

キーが関係性(rel)を表し、値がリンク先URIを表します。この接続情報をViewテンプレートで使用するには次の様にします。

```
<a href# "{href rel"helloworld"}">Hello World</a>
<a href# "{href rel"blog"}">Blog tutorial</a>
```


## URIテンプレート 

リンクには[http://code.google.com/p/uri-templates/ URI template]を用います。[URIテンプレート](http://code.google.com/p/uri-templates/)とはURI用の一種のテンプレート言語です。変数をアサインするとプロセッサにより展開されます。URIテンプレートのは`templated`オプションを`true`にします。$rel` # > ['href' => $uri, 'templated' > true];`

`ブログの記事・アプリケーションリソース`では各`記事の編集、削除ページリソース`等にリンクされています。

```
    /**
     * Links
     *
     * @var array
     */
    public $links = [
        'page_post' # > [Link::HREF > 'page://self/blog/posts/post'],
        'page_edit' # > [Link::HREF => 'page://self/blog/posts/edit{?id}', Link::TEMPLATED > true],
        'page_delete' # > [Link::HREF => 'page://self/blog/posts?_method=delete{&id}', Link::TEMPLATED > true]
    ];
```

ではこれらの`id`(記事ID）はどうやって指定するのでしょうか？
これらの値はリソースの出力から得られたものが割り当てられます。例えば以下の出力ならid=2が割り当てられます。

```
    public function onGet($id = null)
    {
         return ['name' # > 'BEAR', 'id' > 2];
    }
```

次のDBクエリーならselect文の結果の'id'コラムの値です。

```
    public function onGet($id)
    {
        $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
            $sql .# " WHERE id  :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->execute();
            $this->body = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $this;
    }
```

# リンクメソッド 

リソースオブジェクトにリンク用のメソッドを付加します。`on`+リンク名のメソッドがリンクメソッドになります。メソッドにはonGet等で返した値が入力されます。

例えば以下の例は`ブログ記事`に対しての`コメントリソース`をリンクメソッドで繋げています。

```
    public function onLinkComment(array $body)
    {
        $request = $this
        ->resource
        ->get
        ->uri('app://self/User/Entry/Comment')
        ->withQuery(['entry_id' => $body['id']])
        ->eager
        ->request();

        return $request;
    }
```

リンクメソッドの中では実体（実際の値）を返すか、この例のように次のリソースのリンクを返します。

# クライント 

リソースクライアントはこのようにして、リンクメソッドにアクセスします。

```
$blog = $this
->resource
->get
->uri('app://self/User')
->withQuery(['id' => 1])
->linkSelf("blog")
->eager
->request()->body;
```

この例ではID=1のユーザーの"blog"という名前でリンクされてるリソースを取得しています。

## リンクメソッド 

リンクメソッドは３つあります。

|| *メソッド名* || *リンク動作* ||
|| linkSelf($rel) || リンク先と入れ替わります ||
|| linkNew($rel) || リンク先のリソースがリンク元のリソースに追加されます。 ||
|| linkCrawl($rel) || 1:n の関係のリンクの時に複数のリンク先を元のリソースに追加します。||

リソースの追加はbodyに対して行われます。relがキーになったリソース結果の値が追加されます。

### Not implemented / tested 

これらのリンクは未実装またはテストが不十分です。

 # リソースプロパティのリンクをリソースクライアントのlinkメソッドで利用すること
 # @Linkアノテーションでのリンク指定