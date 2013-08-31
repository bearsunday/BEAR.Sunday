---
layout: default
title: BEAR.Sunday
---

# ディペンデンシーインジェクター

BEAR.Sundayのオブジェクトは必要とするオブジェクト、つまり依存(dependency）を外部から代入されることを期待します。 依存を必要とするオブジェクトに対して、インジェクターは*モジュール* に基づき外部からの代入、つまり注入(injection）を行います。モジュールは抽象と実クラスの束縛の集合で、依存解決に用いられます。

BEAR.SundayのDI([Ray.Di](http://code.google.com/p/rayphp/wiki/Motivation?tm=6))ではオブジェクトを提供する側と利用する側にはっきり区別があります。オブジェクトは生成をするか、または利用をするか、そのどちらかで１つのクラスが両方を行う事は原則ありません。

ファクトリーと同じように「依存性の注入」はデザインパターンです。振る舞いと依存解決の分離が基本原理です。

## 依存関係の逆転原則  

 A. 上位モジュールは下位モジュールに依存してはならない。両者は抽象に依存すべきである。

 B. 抽象は詳細（抽象の実装クラス）に依存してはならない。詳細は抽象に依存すべきである。

[Dependency Inversion Principle (DIP)](http://d.hatena.ne.jp/asakichy/20090128/1233144989)

全てのオブジェクトの依存は抽象、つまりインターフェイスや抽象クラスに依存してインジェクトされます。

## オブジェクトグラフ 

依存性の注入ではコンストラクターで依存（オブジェクト）を受け取ります。オブジェクトを生成するためにはまずその依存が必要です。しかしその依存もまた依存が必要で、そのまた..と続きます。つまりオブジェクトを生成するためには、オブジェクトグラフ（オブジェクト間の関係性）を作る事が必要です。 

BEAR.Sundayでは、オブジェクトグラフの作成がbootstrapの時に一度だけ行われます。これをコンパイルと呼び、オブジェクトが振る舞うランタイムと区別しています。

## インジェクターの生成 

インジェクターはモジュールを使って以下の様に生成します。

    $injector = Inject::create([new AppModule]);

上記のスクリプトは以下の記述を簡略化したものです。インジェクター自身の依存も手動でインジェクトできるようにコンストラクタにインジェクターの依存が渡されます。それぞれはインターフェイスに依存していて入れ替えが可能です。

    use Ray\Di;

    $injector = new Di\Injector(
        new Di\Container(
            new Di\Forge(
                new Di\ApcConfig(
                    new Di\Annotation(
                        new Di\Definition, new AnnotationReader
                    )
                )
            )
        ), 
        new AppModule
    );


モジュールは複数設定することができます。

    $injector = Inject::create([new OneModule, new TwoModule, ...]);

※モジュールは原則的はそれぞれ独立しています。`OneModule`でバインドした内容は`TwoModule`内では適用されません。

## モジュール 

モジュールは*@Inject* アノテーションでアノテートされた依存の要求に対するインスタンスまたはインスタンスの取得方法をバインドしインジェクションの設定を行います。

モジュールは`AbstractModule`を継承し、`configure`メソッド内のバンディングDSLで、依存を必要とする場所（インジェクションポイント）と依存（または依存の提供方法）をバインドします。 

例）`CreditCardProcessor`インターフェイスに`CheckoutCreditCardProcessor`クラスをバインドしています。

    class AppModule extends AbstractModule
    {
        /**
         * Configure dependency binding
         *
         * @return void
         */
        protected function configure()
        {
            $this->bind('CreditCardProcessor')->to('CheckoutCreditCardProcessor');
        }

## モジュール内での依存 

モジュールの`configure`メソッド内で依存を得るためにDIが必要な事があります。そのときには*requestInjection* メソッドを使ってインジェクションすることができます。

    $this->bind()->annototatedWith('age')->toInstance(25);
    $user = $this->requireInjection('User');

`User`クラスのインスタンスがつくられ、`@Named("age")`というインジェクションポイントに25がインジェクトされます


## モジュールのインストール 

他のモジュールをインストールして設定を合成することができます。

    $this->install(new MySqlModule);

自己のモジュールの設定を使って、インストールするモジュール内でインスタンスを取得したい時にはインジェクターを作成して渡します。渡されたインジェクターは元モジュールの構成知識を持っているのでその知識で依存解決されます。

    $this->bind()->('socket_path')->toInstance('/tmp/mysql.sock');
    $this->install(new MySqlModule($this);

※MySqlModuleモジュール内では`@Inject @Named('socket_path')`とアノテートすると`'/tmp/mysql.sock'`がインジェクトされます。


## モジュールの合成 
sandboxアプリケーションでは３つのモジュールが合成され１つのアプリケーションの設定を行っています。

#### フレームワークモジュール `FrameworkModule` 
フレームワークそのもの設定です。このモジュールを自作のものに入れ替える、またはこのモジュールをインストールするまえに`bind`するとフレームワークで使われているクラスを入れ替える事ができます。

#### モードモジュール `DevModule`, `ProdModule`,...
実行モードに応じたアプリケーション設定です。sandboxアプリケーションではPROD（プロダクション）、DEV（開発）、STAB（スタブデータ）のモードが用意されています。

#### アプリケーションモジュール `AppModule`
実行モードによらないアプリケーション設定です。

ジュール数は３つに限定されていません。例えばチーム共通のモジュール、同型等サービスの共通ジュール、自作ユーティリティのモジュールなど関心に応じてモジュールを作成して合成利用することができます。