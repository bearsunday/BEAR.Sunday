---
layout: default
title: BEAR.Sunday | アプリケーションクラス
---
## 導入 

アプリケーションオブジェクトはアプリケーションの実行を規定するアプリケーションスクリプトで使用する全てのサービスオブジェクトを保持したオブジェクトです。

# アプリケーションクラス 

以下は最小構成のアプリケーションクラスです。


    use BEAR\Sunday\Extension\Application\AppInterface;

    final class App implements Context
    {
        public $resource;
        public $response;
        public $logger;

        /**
         * Constructor
         *
         * @param ResourceInterface $resource Resource client
         * @param ResponseInterface $response Web / Console response
         * @param ApplicationLogger $logger   Application logger
         *
         * @Inject
         */
        public function __construct
            ResourceInterface $resource,
            ResponseInterface $response,
            ApplicationLogger $logger
        ) {
            $this->resource = $resource;
            $this->response = $response;
            $this->logger = $logger;
            $resource->attachParamProvider('Provides', new Provides);
        }
    }

アプリケーションスクリプトに必要な、リソースクライアント、レスポンス、ロガーがコンストラクタで渡されプロパティに格納されています。

アプリケーション構成によりそれぞれのインターフェイスに応じた適切なオブジェクトがインジェクトされます。例えば開発用の構成ではより多くのデバック情報が提供される開発用のリソースクライントが、API用のアプリケーションではHTML出力する代わりにJSON+HAL（またはJSON)の出力がされるコンポーネントが入ります。

このクラスはインスタンススクリプトでインスタンス化されます。