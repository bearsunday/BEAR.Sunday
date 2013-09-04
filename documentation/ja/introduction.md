---
layout: default_ja
title: BEAR.Sunday | BEAR.Sundayについて
category: はじめに
---

# BEAR.Sundayについて

## BEAR.Sunday, a resource oriented framework for PHP 

## リソース指向 
BEAR.Sundayはアプリケーション内部もRESTアーキテクチャのリソース指向フレームワークです。全域に渡って適用される「依存性の注入」と「アスペクト指向プログラミング」がアプリケーションをシンプルでありながら柔軟でソリッドなものにします。自身のコンポーネントをなるべく持たず従来のライブラリを利用しますがこれも同じ効果のためです。

BEAR.Sundayのシンプルな設計と高い拡張性は*全てがリソース* である事によってもたらされます。データベースアクセスはもちろんwebサービスやローカルファイル、ページコントローラーでさえも同じように「リソース」としてURIを持ち利用やレンダリングが可能です。


## オブジェクトフレームワーク 

BEAR.Sundayでは機能を新たな実装ではなく設計と組み合わせによって実現しようとしますが、そのためには最大限の疎結合と適切な関心の分離それにそれらの動的結合が必要です。

その実現のためBEAR.Sundayは各々のモデルやソフトウエアコンポーネントがどういうものであるかということよりそれらをどう結ぶかという接続技術により注目します。抽象と実装を束縛したモジュールによって依存解決を行い、フレームワークの機能をさまざまなアスペクトの集合とみなしメソッドに動的に横断的関心事を束縛します。オブジェクトにRESTの振る舞いを与えるリソースオブジェクトと合わせたこれらのオブジェクトフレームはBEAR.Sundayのベースになっています。

## ADD (API driven development) 

リソースは内部APIとして機能します。APIはWebアプリケーションプロジェクトのサブセットではなく、アプリケーションドメインの核心として扱われます。Webサイトはそのアプリケーションの１つです。

内部APIとして機能するリソースに、認証のアスペクトを織り込み外部APIとして使う事は容易です。AJAX、モバイルデバイスアプリケーケションやMVC JSのバックエンドとしても自然に機能します。


## 対象 

BEAR.Sundayでは二種類のユーザーを想定しています。

 * *アプリケーションアーキテクト* プロジェクトの構造（フレームワーク）をアプリケーションアーキテクチャとして構築します。必要なサービスやアスペクトを検討して、テンプレートエンジン等のライブラリの選定や既存のライブラリや情報システムの結合なども行います。つまりアーキテクトとはアプリケーションを構成、設計やそれに必要な実装をする人です。

 * *アプリケーションエンジニア* アプリケーションアーキテクチャのほぼ決定された状態でその実装を行います。DIの設定等を行う事は少なく、インジェクトされたサービスを使ってアプリケーションを実装します。アプリケーションの実装を行う人です。

実際にはこれらを混合して行う事も多いでしょうが、規模の大小や参加スタッフによってこの対象を意識するのは有用かと思います。


## 影響を受けたフレームワーク・ソフトウエア技術 

 * [http://code.google.com/p/google-guice/ Google Guice]
 * [http://aopalliance.sourceforge.net/AOP AOP Alliance (Java/J2EE AOP standards)]
 * [Aura](http://auraphp.github.com/)
 * [http://jcp.org/en/jsr/detail?id=311 JSR311 Jax-RS],  [Jersey](http://jersey.java.net/)
 * [http://click.sourceforge.net/ Click Framework]
 * [http://framework.zend.com/ Zend Framework] / [Symfony](http://symfony.com/what-is-symfony) / [Flow3](http://flow3.typo3.org/) / [Ding](http://marcelog.github.com/Ding/) / [Guzzle](http://guzzlephp.org/) / [Doctrine](http://www.doctrine-project.org/about.html) / [PEAR](http://pear.php.net/)

## 開発途中です 

 * BEAR.Sundayは開発途中です。2013年の早期リリースを目指してます。