---
layout: default_ja
title: BEAR.Sunday | blogチュートリアル(2) データベースの設定
category: ブログ・チュートリアル
---
# blogチュートリアル(2) データベースの設定 

## 利用の準備 

[インストール](install.html#DB)のDBのセクションに従ってDBを利用可能にし、テスト用のレコードを入力します。

## 確認
以下のコードでDBレコードの呼び出し確認できるのを確認します。


	php -r '$pdo# new PDO("mysql:host=localhost;dbnameblogbear", "root", "");foreach($pdo->query("SELECT * from posts") as $row){print_r($row);}'
