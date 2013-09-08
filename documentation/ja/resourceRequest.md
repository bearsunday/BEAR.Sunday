---
layout: default_ja
title: BEAR.Sunday | リソースリクエスト
category: リソース
--- 
# リソースリクエスト

## リクエストのタイミング 

リソースのリクエストはlazyとeagerがありリクエストのタイミングに違いがあります。eagerリクエストはすぐにリソースリクエストが行われるのに対して、lazyではviewテンプレートで出現した時に行われます。

### lazyリクエスト
```
$this['posts'] = $this->resource->get->uri('app://self/posts')->request();
```

### eagerリクエスト
```
$this['posts'] = $this->resource->get->uri('app://self/posts')->eager->request();
```

## テンプレートでの表記 

|| 文字列 || {$posts} || 結果がテンプレートエンジンでレンダリングされた文字列 || 
|| 配列 || {$posts['id']} || 結果の連想配列アクセス ||
|| オブジェクト || {$posts->header} || 結果のオブジェクトアクセス ||

※eagerでもlazyでもテンプレートの表記に違いはありません。