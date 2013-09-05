---
layout: default_ja
title: BEAR.Sunday | はじめてのWeb API
category: 「はじめての」チュートリアル
---

# はじめてのWeb API 

[my_first_resource はじめてのリソース]でつくったリソースをWeb APIとして利用してみましょう。

API用built-in webサーバーを起動します。

```
$ cd apps/Sandbox/htdocs
$ php -S localhost:8089 api.php
```


ブラウザのAdd onのRESTクライアント、[https://addons.mozilla.org/ja/firefox/addon/restclient/ Firefox RESTClient], [https://chrome.google.com/webstore/detail/dev-http-client/aejoelaoggembcahagimdiliamlcdmfm?hl=ja Chrome Dev HTTP Client] 等でアクセスします。

※Webブラウザで直接アクセスするとダウンロードされます。

```
http://localhost:8089/first/greeting?name=BEAR
```

JSONで挨拶がかえってきたでしょうか？

これであなたの作成したリソースはWebAPIとして利用できるようになりました。
apache等のサーバーで運用すれば世界中の人からこのリソースをWeb APIとして利用できます！