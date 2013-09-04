#summary リソースアダプター
# 導入 

リソースの`URI`のスキーマはアプリケーションによって特定のリソースアダプターとバインドされ、そのリクエストを行います。

## バインディングDSL 

{{{
$schemeCollection = new SchemeCollection;
$schemeCollection->scheme('app')->host('self')->toAdapter($appAdapter);
$schemeCollection->scheme('page')->host('self')->toAdapter($pageAdapter);
$schemeCollection->scheme('page')->host('*')->toAdapter($httpAdapter);
$this->bind('BEAR\Resource\SchemeCollection')->toInstance($schemeCollection);
}}}

上記のバインディングで、`app://self/`、`page://self/`および、`http://`で始まるリソースが扱える様になります。実際にリクエストを処理するのはリソースアダプター（`$appAdapter`等）です。

このようにURIと特定実装は固定化されたものではなくアプリケーションのバインディングによって決定されます。

## リソースアダプター 

リソースアダプターは実際にはリソースオブジェクトのファクトリーです。`BEAR\Resource\Provider`メソッドを実装してリソースオブジェクトを返します。

例えば`app`, `page`なら`URI`からクラス名を特定してのリソースオブジェクトクラスをインスタンスにして返します。`http`なら`HTTP Clientサービス`を代理実行するオブジェクトです。

メソッドに対応する`onGet`等のメソッド名がリソースの状態を返します。


{{{
App implements ResourceObject, Provider, Adapter
{
    private $injector;
    private $namespace;
    private $path;

    /**
     * Constructor
     *
     * @param InjectorInterface $injector  Application dependency injector
     * @param string            $namespace Resource adapter namespace
     * @param string            $path      Resource adapter path
     *
     * @Inject
     */
    public function __construct(
        InjectorInterface $injector,
        $namespace,
        $path
    ){
        if (! is_string($namespace)) {
            throw new RuntimeException('namespace not string');
        }
        $this->injector = $injector;
        $this->namespace = $namespace;
        $this->path = $path;
    }

    /**
     * (non-PHPdoc)
     *
     * @see    BEAR\Resource.Provider::get()
     * @return object
     * @throws Exception\Host
     */
    public function get($uri)
    {
        $parsedUrl = parse_url($uri);
        $path = str_replace('/', ' ', $parsedUrl['path']);
        $path = ucwords($path);
        $path = str_replace(' ', '\\', $path);
        $host = $parsedUrl['host'];
        $className = "{$this->namespace}\\{$this->path}{$path}";
        $instance = $this->injector->getInstance($className);

        return $instance;
    }
}
}}}

_コンストラクタでリソースオブジェクトのベースディリクトリやインジェクターをインジェクトしてもらって、その依存解決を行いインスタンスにして返します。`app`も`page`も保存場所だけが違う同じものです。_

## 複数アプリケーションのリソース 

インジェクターはオブジェクトの構成知識の全てを持っています。ですので、違うアプリケーションのインジェクターを入手することができれば、同一インスタンスで複数のアプリケーションのリソースを扱うことが可能になります。

例えばプロジェクトを横断するようなアプリケーションや、組織内の認証API等です。HTTPやThrift等ネットワーク越しでなく、同一インスタンスで扱えます。

{{{
$entries1 = $resource->get->uri('app://self/entries')->eager->request();
$entries2 = $resource->get->uri('app://anohter_service/entries')->eager->request();
}}}

## レガシーAPIのラップ 

レガシーなAPIをラップするとログや、キャッシュ、デバック画面などが利用できます。また抽象化されたAPIはリファクタリングも容易になりやすいのではないでしょうか。リソースアダプターをレガシーAPIのプロキシーとして実装します。

{{{
$entries1 = $resource->get->uri('office://self/room/resrvation/')->eager->request();
}}}

## URIの可能性 

扱う情報に名前(URI)を与え全てを`API`をとして扱える様にすることはBEAR.Sundayの核心です。フレームワークによって固定化されたスキーマはなく、そのバインディングはアプリケーションドメインです。

`URI`を持った情報はリソースAPIとして雑なシステムのハブとしても機能します。違うフレームワーク、違う言語、あるいは複数の種類のクライアント(Web / Mobile App / Console)や、ストレージの変更、R/Wでのストレージをの区別（CQRS)などす。それらの中心のハブとして機能する可能性があります。