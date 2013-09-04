---
layout: default
title: BEAR.Sunday | アノテーション
---
#アノテーション

## 導入

アノテーションとは、クラスやメソッドのコードに対するメタデータです。BEAR.Sundayでは[http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html Doctrine Annotations]を用います。メソッドやクラスのdocコメントに書かれたアノテーションは、DIでインジェクションポイントの指定に使われたり、AOPでインターセプターを束縛するときのマーカー等に使われます。

## ビルトイン・アノテーション 

`Ray.Di`や`BEAR.Framework`にはデフォルトで用意されているアノテーションがあります。`BEAR.Framework`のアノテーションはほとんどがAOPで使われるもので、モジュールでの束縛されなければ動作に影響はありません。

### Ray.Di 

|| アノテーション || 意味 || プロパティ ||
|| `@Inject` || インジェクションポイント || optional:必須ではない ||
|| `@Named` || インジェクションポイント名 || value:名前 ||
|| `@Scope` || スコープ || value:"singleton" or "prototype"(デフォルト) ||
|| `@ImplementedBy` || デフォルトインプリメンテーション || クラス ||
|| `@ProviderdBy` || デフォルトプロバイダー || プロバイダー ||

詳しくはRay.Diの[マニュアル](http://code.google.com/p/rayphp/wiki/Motivation?tm=6)をご覧下さい。

### BEAR.Framework 

|| アノテーション || 意味 || プロパティ || インターセプター ||
|| `@Cache` || キャッシュ || value:キャッシュ秒数 || `BEAR\Framework\Interceptor\CacheLoader` ||
|| `@CacheUpdate` || キャッシュ更新 || n/a || `BEAR\Framework\Interceptor\CacheUpdate` ||
|| `@Db` || DAOインジェクト|| n/a ||`BEAR\Framework\Interceptor\DbSetter` ||
|| `@DbPager` || DBページャー || n/a || n/a ||
|| `@Transactional` || トランザクション || n/a || `BEAR\Framework\Interceptor\Transaction` ||
|| `@Time` || 時間 || n/a || `BEAR\Framework\Interceptor\TimeStamper` ||

_インターセプターの詳しい説明は現在ありません。ソースをご覧下さい。_

## ユーザーアノテーション 

    /**
    * @Annotation
    * @Target({"METHOD","CLASS"})
    *
    */
    class Foo
    {
        public $value;
    }

これはメソッドとクラスに付ける事のできるアノテーションの例です。一つだけプロパティを持つアノテーションを *単一値アノテーション * と呼び以下のように記述します。

    /**
     * @Foo("bar")
     */

この場合`"bar"`が`$value`プロパティに代入されます。他にもプロパティのないマーカーアノテーション、複数のプロパティを持つ *フルアノテーション* 等があります。

詳しくは`Doctrine Annotation`の[マニュアル](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html)を参照してください。