---
layout: default_ja
title: BEAR.Sunday | blogチュートリアル(3) 記事リソースの作成
category: ブログ・チュートリアル
---
# blogチュートリアル(3) 記事リソースの作成
## リソースオブジェクト 

BEAR.Sundayはリソース指向のフレームワークです。意味のある情報のまとまりに*リソース* としてURIが与えられ、GET/POST等リソースリクエストに対応するリクエストインターフェイスを持ちます。

MVCでいうとCやVというコンポーネントの役割はBEAR.Sundayではそれぞれページコントローラーとしてページリソース、モデルはアプリケーション(app)リソースが担います。これらのリソースは基本的に１リソース＝１クラスにマップされ、また名前空間を含んだクラス名がURIに対応しリクエストインターフェイスはメソッドとして記述します。

例えば、記事を閲覧するページは記事表示ページリソース(page://self/blog/posts)、記事そのものを表すのは記事アプリケーションリソース(app://self/posts)といった具合です。このチュートリアルではそれぞれ*記事表示ページ*、*記事リソース* と表記します。

## 記事リソース 

アプリケーションリソースはいわばアプリケーションの*内部API* です。MVCでいうとモデルに当たります。内部にデータベースアクセスやビジネスロジックを持ちページコントローラーの役割を持つページリソースに対してアプリケーション内部のAPIを提供します。

記事リソースでは閲覧のためにGETリクエストに対応するonGetメソッドを実装します。

このようなリソースクラスのひな形から実装します。

    <?php
    namespace Sandbox\Resource\App;

    /**
     * Posts
     *
     */
    class Posts extends ResourceObject
    {
        /**
         * Get
         */
        public function onGet($id = null)
        {
            $this->body = _DBから読み出したデータ_
            return $this;
        }
    }

リクエストに応じたメソッド（リクエストインターフェイス）内ではデータをbodyプロパティにセットして$thisを返します。

 Note: $bodyプロパティにセットする代わりにデータを直接返すこともできます。その場合でも受け取る方にはreturn $this;と同じものが返ります。

## リソース・スタブ 

onGetメソッドを記述するまえに、ダミーのデータでリソースを利用してみましょう。スタブデータ（ダミーデータ）を使ったリソースはアプリケーションのプロトタイピングやテスト等に便利です。sandboxアプリケーションは専用の`STABモード`を持っていて、アプリケーションオブジェトを作成するときに指定します。

`apps/Sandbox/htdocs/api.php`(APIアクセス） または `apps/Sandbox/htdocs/web.php`(webアクセス)

    $mode = 'Stab";
    $app = require '/path/to/script/instance.php';

スタブデータを用意します。

`apps/Sandbox/stub/resource.php`

    return [
        'Sandbox\Resource\App\Posts' =>
            [
                [
                    'id' => 0,
                    'title' => 'Alan Kay 1',
                    'body' => 'People who are really serious about software should make their own hardware.',
                    'created' => '2011-05-07 16:13:11'
                ],
                [
                    'id' => 1,
                    'title' => 'Alan Kay 2',
                    'body' => 'Perspective is worth 80 IQ points.',
                    'created' => '2011-05-07 16:13:22'
                ],
                [
                    'id' => 2,
                    'title' => 'Alan Kay 3',
                    'body' => 'The best way to predict the future is to invent it.',
                    'created' => '2011-05-07 16:13:33'
                ]
             ]
    ];

作成したappリソースをコンソールで確認します。


    $ php apps/Sandbox/htdocs/api.php get app://self/posts
    200 OK
    [BODY]
    0:array (
      'id' => 0,
      'title' => 'Alan Kay 1',
      'body' => 'People who are really serious about software should make their own hardware.',
      'created' => '2011-05-07 16:13:11',
    )
    1:array (
      'id' => 1,
      'title' => 'Alan Kay 2',
      'body' => 'Perspective is worth 80 IQ points.',
      'created' => '2011-05-07 16:13:22',
    )
    2:array (
      'id' => 2,
      'title' => 'Alan Kay 3',
      'body' => 'The best way to predict the future is to invent it.',
      'created' => '2011-05-07 16:13:33',
    )

ダミーのデータでどのようなリクエスト結果を求めるのかが明らかになりました。

## スタブモジュール 

リソースがスタブのデータを返すのは、リソースの各メソッドにスタブインターセプターを束縛してるアスペクト指向プログラミングによって実現されています。

apps/Sandbox/Module/StabModule.php

    foreach ($stub as $class => $value) {
        $this->bindInterceptor(
            $this->matcher->subclassesOf($class),
           $this->matcher->startWith('on'),
            [new Stab($value)]
        );
    }

 Note:クライントはリソースをリクエストしてるつもりでも、実際はクライントとリソースの間に割り込んだ（インターセプトした）スタブインターセプターがダミーのデータを返しています。

## リクエスインターフェイス実装 

次は実際にDBをアクセスしてデータを取り出すGETリクエストに対するonGetメソッドを実装します。

BEAR.Sundayは自身のデータベース利用ライブラリや抽象化ライブラリを持ちません。アプリケーションリソースクラス内で他のライブラリを使ってSQLを直接利用したり、ORMを使用したりします。sandboxアプリケーションでは[http://www.doctrine-project.org/projects/dbal.html Docrine DBAL]でSQLを記述します。

_Sandbox/Resource/App/Blog/Posts.php_

    <?php
    /**
     * @package    Sandbox
     * @subpackage Resource
     */
    namespace Sandbox\Resource\App\Blog;

    use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
    use BEAR\Resource\AbstractObject as ResourceObject;
    use BEAR\Resource\Link;
    use BEAR\Resource\Code;
    use PDO;

    use BEAR\Sunday\Annotation\Db;
    use BEAR\Sunday\Annotation\Time;
    use BEAR\Sunday\Annotation\Transactional;
    use BEAR\Sunday\Annotation\Cache;
    use BEAR\Sunday\Annotation\CacheUpdate;

    /**
     * Posts
     *
     * @package    Sandbox
     * @subpackage Resource
     *
     * @Db
     */
    class Posts extends ResourceObject
    {
        use DbSetter;

        /**
         * @var string
         */
        public $time;

        /**
         * @var string
         */
        protected $table = 'posts';

        /**
         * @var array
         */
        public $links = [
            'page_post' # > [Link::HREF > 'page://self/blog/posts/post'],
            'page_item' # > [Link::HREF => 'page://self/blog/posts/post{?id}', Link::TEMPLATED > true],
            'page_edit' # > [Link::HREF => 'page://self/blog/posts/edit{?id}', Link::TEMPLATED > true],
            'page_delete' # > [Link::HREF => 'page://self/blog/posts?_method=delete{&id}', Link::TEMPLATED > true]
        ];

        /**
         * @param int $id
         *
         * @return Posts
         * @Cache(100)
         */
        public function onGet($id = null)
        {
            $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
            if (is_null($id)) {
                $stmt = $this->db->query($sql);
                $this->body = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql .# " WHERE id  :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue('id', $id);
                $stmt->execute();
                $this->body = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return $this;
        }

            /**
             * @param string $title
             * @param string $body
             *
             * @return Posts
             * @Time
             * @Transactional
             * @CacheUpdate
             */
            public function onPost($title, $body)
            {
                $values = [
                    'title' => $title,
                    'body' => $body,
                    'created' => $this->time
                ];
                $this->db->insert($this->table, $values);
                //
                $lastId = $this->db->lastInsertId('id');
                $this->code = Code::CREATED;
                $this->links['new_post'] # [Link::HREF => "app://self/posts/post?id{$lastId}"];
                $this->links['page_new_post'] # [Link::HREF => "page://self/blog/posts/post?id{$lastId}"];
                return $this;
            }

        /**
         * @param int    $id
         * @param string $title
         * @param string $body
         *
         * @return Posts
         * @Time
         * @CacheUpdate
         */
        public function onPut($id, $title, $body)
        {
            $values = [
                'title' => $title,
                'body' => $body,
                'created' => $this->time
            ];
            $this->db->update($this->table, $values, ['id' => $id]);
            $this->code = Code::NO_CONTENT;
            return $this;
        }

        /**
         * @param int $id
         *
         * @return Posts
         * @CacheUpdate
         */
        public function onDelete($id)
        {
            $this->db->delete($this->table, ['id' => $id]);
            $this->code = Code::NO_CONTENT;
            return $this;
        }
    }

リソースクラスではリソースのリクエストインターフェイスに対応するメソッドを記述します。この記事リソースでは$idが指定されると記事１つが、指定されないと記事全てを返しています。

## コマンドラインからリソースの利用 

_Sandbox/Resource/App/Posts.php_ に設置した`Sandbox/Resource/App/Posts`クラスのこのappリソースは`app://self/posts`というURIが与えられます。

作成したリソースはをコマンドラインからみてみましょう。まずはアプリケーションの実行モードを戻します。

public/api.php

    $mode = 'Stab";
    $app = require '/path/to/script/instance.php';

コンソールで呼び出します。

    $ php api.php get app://self/blog/posts

    200 OK
    [BODY]
    array (
      0 => 
      array (
        'id' => '1',
        'title' => 'タイトル',
        'body' => 'これは、記事の本文です。',
        'created' => '2011-07-01 22:30:25',
        'modified' => NULL,
      ),
      1 => 
      array (
        'id' => '2',
        'title' => 'またタイトル',
        'body' => 'そこに本文が続きます。',
        'created' => '2011-07-01 22:30:25',
        'modified' => NULL,
      ),
      2 => 
      array (
        'id' => '3',
        'title' => 'タイトルの逆襲',
        'body' => 'こりゃ本当に面白そう！うそ。',
        'created' => '2011-07-01 22:30:27',
        'modified' => NULL,
      ),
    )

STABモードの実行と同じ形式の出力が得られました。

モードを切り替えることでダミーデータ表示がいつでもできます。

    Note: `self`は自己のアプリケーションのリソースという意味です。BEAR.Sundayでは他のアプリケーションのリソースをリクエストする事や、アプリケーションを横断して利用するリソースを設置することが可能です。

引き数はクエリーの形式で指定します。

    $ php apps/Sandbox/htdocs/api.php get 'app://self/posts?id=1'


## aliasの設定 

シェルスクリプトでaliasをフルパスで設定しておくと便利です。

_~/.bash_profile_

    alias api='php /path/to/apps/Sandbox/htdocs/api.php'
    alias web='php /path/to/apps/Sandbox/htdocs/web.php'

上段がリソースのAPI利用、下段はwebリクエストに対応します。簡単な表記になり、どのディレクトリからもコンソールでリソースを利用できるようになりました。バッチ処理などのOSからのスクリプト利用にも便利です。

    // APIアクセス
    $ api get app://self/posts

    // webアクセス
    $ web get /posts

## API駆動開発

このようにBEAR.Sundayでは内部API開発をベースにwebアプリケーションを構築します。リソースはサービスレイヤーとして機能し、データソースやビジネスロジックを含んだ処理のまとまりにRESTfulな限定された統一とインターフェイスと名前（URI）を与えます。

webアプリケーションを元に外部API用インターフェイスを作成・提供する_のでなく_、内部リソースAPIをベースにアプリケーションをAPIの集合のように構築します。

## ランタイムインジェクション 

このappリソースはGETリクエストされる度、直前にsetDb()が呼ばれDBオブジェクが外部から代入（インジェクト）されます。このクラスにはどのDBオブジェクトを利用するかという指定はなく、外部からの代入にその選定を任せている事に注目してください。*GET* リクエストではスレーブ用DBオブジェクトが、その他の*PUT*,*POST*,*DELETE* リクエストではマスター用DBオブジェクトが代入されます。

この実行時（ランタイム）のオブジェクトのインジェクションをランタイムインジェクションと呼びます。これは特定のメソッド(この場合onGet)に、そのメソッドの実行前に呼び出されるインターセプター(この場合Dbオブジェクトインジェクター）が束縛されていることで実現されています。

このDBオブジェクトがランタイムでインジェクトされる仕組みはBEAR.Sundayで固定化された仕組みではなくappModuleでインストールした`DotriDbalModule`の働きです。`DotriDbalModule`では*@Db* とアノテートされたクラスのメソッドにはDBインジェクターを束縛していて、そのDBインジェクターがリクエストメソッドを見てmaster/slave DBを決定し、DBオブジェクトをセットしています。