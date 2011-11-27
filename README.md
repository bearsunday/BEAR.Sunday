
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

    $ php apps/01-helloworld/htdocs/index.php --url /Hello
+モデル（アプリケーションリソース）

    $ php apps/01-helloworld/htdocs/index.php --url /HelloResource
+テンプレートエンジン

    $ php apps/02-template-engine/htdocs/index.php --url /Php
    $ php apps/02-template-engine/htdocs/index.php --url /Smarty3
    $ php apps/02-template-engine/htdocs/index.php --url /Twig
    $ php apps/02-template-engine/htdocs/index.php --url /Haanga
+アスペクト指向

    $ php apps/03-aop/htdocs/index.php --url /Log

## Built in web server
    $ php -S localhost:8080 apps/01-helloworld/htdocs/index.php 

ブラウザで

http://localhost:8080/Hello

## 評価/検討点

 * ファイルレイアウト
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
 * 設定ファイル不使用
 * include_path不使用
