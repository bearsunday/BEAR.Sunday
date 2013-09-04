#summary Ray.Di Ray.Aop イントロダクション
# 導入 

BEAR.SundayではDI, Dependency Injection（依存性の注入）パターンとAOP, Aspect Oriented Programing（アスペクト指向プログラミング）をコードの全域に渡って利用しています。[Ray](http://code.google.com/p/rayphp/wiki/Motivation?tm=6)という[http://ja.wikipedia.org/wiki/Google_Guice Google Guice]のPHPクローンのDI/AOPフレームワークを利用していて、アノテーションを使用したオブジェクトへの依存性の注入 をサポートしているのが特徴です。

AOPは[http://aopalliance.sourceforge.net/ AOP Alliance]が策定したインターフェイスをPHPで実装しています。アノテーションや名前で指定した特定のメソッドに複数の横断的処理を束縛する事ができます。

動的言語のDI/AOP導入はしばしばパフォーマンス上の懸念がもたれます。しかしBEAR.Sundayは低結合で多くの抽象化機能を持ちながら、APCコンテナを使いオブジェクトグラフの生成を再利用することでDI/AOP導入によるパフォーマンス低下が原理的にほとんどありません。アプリケーションのミニマムブートストラップコストも非常に低いのが特徴です。