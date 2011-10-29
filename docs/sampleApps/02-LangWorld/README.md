# LangWorld

## Page/Lang.php

$_GETクエリーに応じてページリソースへのクエリーが代わり、それに応じてページ内からRoへのクエリーも同様に変わります。
onWebメソッド内でのinjectGetによってonGet内の引数を指定しています。


## Page/LangCookie.php

$_GETクエリーの代わりにCookieの内容に応じて変わります。Cookieの取得にはAura\Web\Contextを使用しています。
