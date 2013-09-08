---
layout: default_ja
title: BEAR.Sunday | アプリケーションスクリプト
category: アプリケーション
---

BEAR.Sundayではフレームワークが固定された実行フローを持つ代わりに、アプリケーションスクリプトがアプリケーションがどのようなフローで実行されるかを表します。

変更するにはこのアプリケーションスクリプトを直接編集します。

# アプリケーションスクリプト 

以下は`Sandboxアプリケーション`のプロダクションスクリプトです。

    // Application instance with loader
    $mode = 'Prod';
    $app = require dirname(__DIR__) . '/scripts/instance.php';

    // Dispatch
    list($method, $pagePath, $query) = $app->router->match($GLOBALS);

    // Request
    try {
        $app->page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
    } catch (NotFound $e) {
        $code = 404;
        goto ERROR;
    } catch (BadRequest $e) {
        $code = 400;
        goto ERROR;
    } catch (Exception $e) {
        $code = 503;
        error_log((string)$e);
        goto ERROR;
    }

    // Transfer

    OK: {
        $app->response->setResource($app->page)->render()->prepare()->send();
        exit(0);
    }

    ERROR: {
        http_response_code($code);
        require dirname(__DIR__) . "/http/{$code}.php";
        exit(1);
    }

アプリケーションインスタンススクリプトからアプリケーションオブジェクトを取得しています。アプリケーションオブジェクトはアプリケーションスクリプトで必要な全てのサービスオブジェクトをプロパティに保持しています。

## スクリプト解説 

### アプリケーションインスタンス取得 

    $mode = 'Prod';
    $app = require dirname(__DIR__) . '/scripts/instance.php';

アプリケーションインスタンススクリプトからアプリケーションオブジェクトを取得しています。このスクリプトではクラスローダーの設定も行われます。

### ディスパッチ 

    // Dispatch
    list($method, $pagePath, $query) = $app->router->match($GLOBALS);

グローバル変数からページリソースに対するリクエストメソッド、URI、クエリーが取り出されます。

### ページリソースリクエスト、出力 

以下、その変数を使ってページをリクエストします。OKとERRORでページ出力を変えています。