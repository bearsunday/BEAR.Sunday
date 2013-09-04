#summary データベース

# 導入 

BEAR.Sundayは独自のDB / ORMライブラリを持ちませんが、DB利用を補助する仕組みがいくつか用意されています。`Doctrine DBAL, ORM`,`ZF2\Db`, `PDO`等のライブラリを選択して、リソースオブジェクトにインジェクト、またはインターセプトしてデータベースを使用します。

_sandboxアプリケーションではDoctrine.DBALを使っています。_

## @Db 

sandboxアプリケーションではクラスに`@Db`とアノテートしているクラスの`onメソッドにDbオブジェクトインジェクターがバインドされます。@Dbとクラスにアノテートされた`onGet`リクエストがコールされたタイミングでDBオブジェクトがインジェクトされます。DBの接続と利用の関心は分離されていて、利用コードは接続に関して無知です。

DB利用コード

    /**
     * @Db
     */
    class Posts extends ResourceObject implements DbSetterInterface
    {
        /**
         * @var Doctrine\DBAL\Connection
         */
        protected $db;

        public function setDb(DriverConnection $db = null)
        {
            $this->db = $db;
        }

        public function onGet($id)
        {
            $sql = "SELECT id, title, body, created, modified FROM {$this->table}";
            $this->body = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $this;
        }
    }
DBインジェクターはマスターDBとスレーブDBの接続情報それぞれ@Named("master_db") と @Named("slave_db")を依存に持ちます、sandboxアプリケーションでは!ConstantModuleでそれらの定数の依存がインストールされています。

### master/slave自動選択 
`DbInjector`はリクエストメソッドを見てDB接続先選択し(GET=slave)、接続してDBオブジェクトをセットします。

### パーティショニング 
IDによるDBパーティショニングが必要な場合には、インジェクターを別に用意しバインドし、選択ロジックを記述します。

## @!DbPager 

このDBインジェクターはメソッドが`@DbPager`とアノテートされてると、クエリーをDBページャーのクエリーに変換し、ページャーのメタ情報がヘッダーの *pager* というキーに格納されます。

|| maxPerPage || ページ辺りのアイテム数 ||
|| current || 現在のページ番号 ||
|| total || トータルページ数 ||
|| hasNext || 次の存在 ||
|| hasPrevious || 前の存在 ||
|| html || ページャーリンク(twitter/bootstrapフォーマット) ||

例えば`$posts`とアサインされたテンプレートでページャーリンクを指定するには以下のようにします。

    {$posts->headers.pager.html}

_※smartyテンプレートエンジンの場合_

## @Transactional
` @Transactional `とアノテートされたメソッドにはトランザクションインターセプターがバインドされています。

    /**
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

        return $this;
    }

### @Time 
### @!CacheUpdate 
このメソッドは`@Time`でバインドされた現在時刻($this->time)を利用し、トランザクションを使ってinsertクエリーが行われます。commitされた時だけ`@CacheUpdate`でバインドされたキャッシュアップデーターが働き古いキャッシュが破棄され新しいものに変わります。

## ヒント 
 * SQLやテーブル名を依存として@Injectする事も検討してみましょう。
 * バリデーションはメソッド内で行わず、インターセプターとしてバインドします。フォームバリデーションと兼用できるかもしれません。
 * メソッド内の解析済みをクエリーを再利用して、インターセプターで`execute`だけを行うインターセプターとかどうでしょうか。