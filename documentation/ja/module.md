---
layout: default_ja
title: BEAR.Sunday | モジュール
category: DI＆AOP
---

# モジュール 

モジュールはDIとAOPの束縛（バインド）の設定の集合です。オブジェクトの抽象、つまりインターフェイスや抽象クラスと実装、実クラスやファクトリーの束縛、それにメソッドとその横断的振る舞い、つまりアスペクトの束縛の集合です。DIの設定ではインターフェイスに対してクラスを束縛します。AOPは特定のメソッドに対してインターセプターを束縛します。

モジュールはこの束縛の集合によってオブジェクトがどのように組み立てられ利用されるかを決定します。インジェクターはそのモジュールを利用してオブジェクトの生成を行います。そのオブジェクトのメソッドの利用には束縛されたインターセプターが機能します。

例えば`APIモジュール`では出力インターフェイスにJSON出力のクラスが束縛されているので出力がJSONになります。出力オブジェクトがモードに応じて振る舞いを*変えているのではない事*に注目してください。モードに応じて振る舞いを帰るのではなく、モードに応じてオブジェクトの構成を変更しています。

BEAR.Sundayは変更に対して開いていて修正に対して閉じている[オブジェクトの開放閉鎖原則(OCP)](http://d.hatena.ne.jp/asakichy/20090126/1232979830)に従っています。

## 束縛DSL 

モジュールは`AbstractModule`を継承し、`configure`メソッド内ではバインドDSLをDSLを使い@Injectでアノテートされたインジェクションポイントにどのようにインスタンス提供するかを束縛します。 


## バインドの種類 

`AbstractModule`を継承したモジュールの`configure`メソッド内で、`@Inject`でアノテートされたインジェクションポイントにどのようにインスタンス提供をするかを束縛します。インスタンスの提供は様々な方法があり、引き数なしのクラス名を指定する`Linked Binding`、名前を使って束縛する`"Named" Binding`、プロバイダーといわれる専用のファクトリーを使って束縛する`Provider Bindings`等があります。

# 束縛 (binding) 

## Linked Binding 

インターフェイス名と実クラス名を束縛します。

    $this->bind('TransactionLog')->to('DatabaseTransactionLog');

最も単純で一般的な方法です。コンストラクタに引数を渡す事は出来ない事に注意してください。これは以下のように`@Inject`で指定された`TransactionLog`インターフェイスに`new DatabaseTransactionLog();`で生成したインスタンスをインジェクトします

_コンシュマー（インジェクトされる側）_
    /**
     * @Inject
     */
    public function setLog(TransactionLog $log)

## "Named" Binding 

バインドに名前をつけます。

    $this->bind('CreditCardProcessor')->annotatedWith('Checkout')->to('CheckoutCreditCardProcessor');

_コンシュマー_

    /**
     * @Inject
     * @Named("serceret_key")
     */
    public function setProcessor(CreditCardProcessor $processor)

インターフェイスがないscalar型への束縛には`@Named`で指定する名前が必須です。

```
 $this->bind()->annotatedWith('secret_key')->toInstance(1234);
```

_コンシュマー_
```
/**
 * @Inject
 * @Named("serceret_key")
 */
public function setKey($stringKey)
```

## Instance Bindings 

インスタンス（実体）をバインドします。これはnewキーワードで作成されたクラスのインスタンスに限りません。数値や文字列も含みます。インスタンスバインディングは他のバインディグ方法が利用可能なら、なるべく避けるべきバインディングです。他のbind()と違って実際に使用されないインスタンスも作成されてしまいます。

```
$this->bind()->annotatedWith("login_timeout_seconds")->toInstance(10);
```

## Provider Bindings 

オブジェクトのコンストラクションに引数が必要なものや、オブジェクトのコンストラクションが複雑なものはプロバイダーというファクトリークラスをバインドします。プロバイダーは`provider`インターフェイスを実装したgetメソッドがインスタンスを返します。

```  
$this->bind('TransactionLog')->toProvider('DatabaseTransactionLogProvider');
```

※TransactionLogインターフェイスはDatabaseTransactionLogProvidergetプロバイダーにバインドされます。このインジェクトが行われるタイミングでgetメソッドがコールされインスタンスが取得されます。


## Constructor Bindings 
コンストラクターバインディングは、3rd partyのクラス（BEAR.Sunday、そのアプリケーション以外）、つまり`@Inject`でインジェクションポイントがマークされてないクラスのインジェクションを行うための束縛です。

コンストラクターの変数名をインジェクションポイントとして指定して束縛ドします。

```
$this->bind('TransactionLog')->toConstructor(['db' => new Database]);
```

## Scope 

オブジェクトを*Singleton* として指定するために２つの方法があります。１つはクラスにアノテーションで指定する方法、もう一つはバインドの時に指定する方法です。

```
/**
 * @Scope(Scope::SINGLETON)
 */
public class InMemoryTransactionLog implements TransactionLog
{
}
```

```
$this->bind('TransactionLog')->to('InMemoryTransactionLog')->in(Scope::Singleton);
```

## Ray.DI 

BEAR.Sundayが利用しているDIフレームワーク、[http://code.google.com/p/rayphp/wiki/Bindings Ray.Di Ray.Di]のマニュアルもご覧下さい。 