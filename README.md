
BEAR, a resource oriented framework.
=============================

PHP5.4専用フレームワークBEAR(Sunday)の評価用プロトタイプです。

## Requirement

 * php 5.4RC1+
 
## Install
    $ git clone git://github.com/koriym/BEAR.Sunday.git
    $ cd BEAR.Sunday
    $ git submodule update --init

## CLI

ミニマム

    $ php apps/01-demo/htdocs/dev.php get /hello

+モデル（アプリケーションリソース）

    $ php apps/01-demo/htdocs/dev.php get /helloresource

+テンプレートエンジン

    $ php apps/01-demo/htdocs/dev.php get /template/twig
    $ php apps/01-demo/htdocs/dev.php get /template/smarty3
    $ php apps/01-demo/htdocs/dev.php get /template/haanga
    $ php apps/01-demo/htdocs/dev.php get /template/php

+アスペクト指向

    $ php apps/01-demo/htdocs/dev.php get /aop/log

+HTTPリソース

    $ php apps/01-demo/htdocs/dev.php get /http/googlenews
    $ php apps/01-demo/htdocs/dev.php get /http/multi

## APIコール

### app:// アプリケーションリソース
    $ php apps/01-demo/htdocs/api.php get app://self/greeting?lang=en
    $ php apps/01-demo/htdocs/api.php get app://self/greeting?lang=ja
    
### page:// ページリソース
    $ php apps/01-demo/htdocs/api.php get page://self/hello

## マルチアプリケーションリソース

    $ php apps/01-demo/htdocs/dev.php get /app/hello

## Hyper Link

    $ php apps/01-demo/htdocs/dev.php get /hyperlink/restbucks?drink=latte
    $ php apps/01-demo/htdocs/dev.php get /hyperlink/restbucks?drink=coffe
    
## Router
	$ php apps/01-demo/htdocs/router.php get /helloresource/ja
	$ php apps/01-demo/htdocs/router.php get /helloresource/en


## Built in web server
    $ php -S localhost:8080 apps/01-demo/htdocs/dev.php 

ブラウザで

http://localhost:8080/hello

## その他

 * オブジェクトキャッシュを使う時はdev.phpの代わりにprod.phpを使います。

## 遊んでみよう

 * ページリソースを２つ読み込んで２つのページを１つのページにしてみる
 * ResourceObject/Greetingをコピーして他のアプリケーションリソースをつくってみる
 * Interceptor/の下のLog.phpをコピーしてメソッドの実行時間を計るタイマーのインターセプターをつくってみる
 * ResourceAdapterProviderにcsv://スキーマを追加してcsv://path/to/csv/fileでcsvファイルが扱えるスキーマをつくる
 * ページからアプリケーションリソースのアクセスの全てのログを取るリクエストハンドラーを実装してみる
 * Symfony2のAPCローダーをつかってどれくらい速度アップするかためしてみる
 * Thriftを使って他の言語にもリソースを実装してみる
 * デーモンとしてリソースサーバーを立ち上げてHTTPでAPIを提供するのとどちらが高速か調べてみる
 
## 評価/検討点 U

 * ファイル/ディレクトリ レイアウト
 * ファイル/ディレクトリ 命名
 * Ray.DiでのModuleバインディングの理解
 * 全体構成、フローの把握のしやすさ、見通し感
 * コードの読みやすさ
 * リクエストDSLの表記
 * 設定ファイルを使っていない点
 * include_pathを使っていない点
 * 短いエラー表記
 
## 評価/検討点 F
 
 * 基本パフォーマンス
 * オブジェクトグラフキャッシュ
 * マルチアプリケーション
 * テンプレートエンジンとの粗結合
 * テンプレートエンジンパフォーマンス
 * 開発用 CLI / Built in webサーバー共用スクリプト
 * Traitとインジェクトアノテーション@Inject
 * Traitによるページ単位でのテンプレートエンジン選択
 * pageコントローラー
 * 開発用ルーター
 * スタティックコールしかないライブラリの初期化
 * インジェクションバインディングのフレームワークモジュールとアプリケーションモジュール
 * コーディング 
 * テスタビリティ
 * ユーザードライバビリティ、拡張性
 * フレームワークのメンテナンス性
 * アプリケーションのテストカバレッジ
 * 3rdパーティーライブラリの利用方法、容易さ
 * bootstrapスクリプト
 
=======
 * 設定ファイル不使用
 * include_path不使用
