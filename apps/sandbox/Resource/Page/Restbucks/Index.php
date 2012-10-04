<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\Page\Restbucks;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Inject\AInject;
use BEAR\Resource\LoggerInterface;
use BEAR\Resource\Code;
use Ray\Di\Di\Inject;

/**
 * Restbucks order
 *
 */
class Index extends Page
{
    use ResourceInject;
    use AInject;

    public $body = [
        'ordered' => false
    ];

    /**
     * @Inject
     *
     * @param LoggerInterface $logger
     */
    public function setResourceLogger(LoggerInterface $logger)
    {
        $this->resourceLogger = $logger;
    }

    /**
     * Get
     */
    public function onGet()
    {
        return $this;
    }

    /**
     * Post
     *
     * @param  string            $drink
     * @throws \RuntimeException
     *
     * @return \Sandbox\Resource\Page\Restbucks\Index
     */
    public function onPost($drink)
    {
        // Story 1: As a customer, I want to order a cofee so that Restbucks can prepare my drink
        // （お客）ドリンクを注文
        $orederResponse = $this
        ->resource
        ->post
        ->uri('app://self/restbucks/order')
        ->withQuery(['drink' => $drink])
        ->eager
        ->request();

        if ($orederResponse->code !== 201) {
            throw new \RuntimeException('Sorry, Not available. Try "latte"');
        }

        // Story 2: As a customer. I want to be able to change my drink to suite my taste
        // （お客）エクストラショットを追加し注文を変更
        $orderId = $orederResponse['id'];
        $updateResponse = $this
        ->resource
        ->put
        ->uri('app://self/restbucks/order')
        ->withQuery([
            'id' => $orderId,
            'additon' => 'shot'
        ])
        ->eager
        ->request();

        // Story 3: As a customer. I want to be able to pay my bill to recieve my drink
        // （お客）支払いをする
        $paymentUri = $this->a->href('payment', $updateResponse);
        $paymentResponse = $this
        ->resource
        ->put
        ->uri($paymentUri)
        ->addQuery([
            'id' => $orderId,
            'card_no' => '0000123408010908',
            'expires' => '021014',
            'name' => 'BEAR SUNDAY',
            'amount' => 1
        ])
        ->eager
        ->request();

        // Story 4: As a barista, I want to see the list of drinks that I need to make, so that I can serve my customers.
        // （店）お客さんに提供するために注文をみて、注文を"準備中"に変更する

        // get one order
        $ordersResponse = $this
        ->resource
        ->get
        ->uri('app://self/restbucks/orders')
        ->eager
        ->request();
        $order = $ordersResponse->body['order'][0];
        // change status
        $editUri = $order['_links']['edit']['href'];
        $response = $this
        ->resource
        ->put
        ->uri($editUri)
        ->addQuery(['status' => 'preparing'])
        ->eager
        ->request();

        // Story 5: As a barista, I want to check that a customer has paid for their drink so that I can serve it
        // (店) ドリンクを渡すために支払いを確認
        $paymentUri = $order['_links']['payment']['href'];

        $paymentResponse = $this
        ->resource
        ->get
        ->uri($paymentUri)
        ->eager
        ->request();
        if ($paymentResponse->code !== 200) {
            throw new \RuntimeException('Payment needed', $paymentResponse->code);
        }

        // Story 6: As a barista, I want to remove drinks I have made from the pending list so that I don't make duplicats
        // （店）ダブってつくらないように注文を削除
        $orderUri = $order['_links']['self']['href'];
        $deleteResponse = $this
        ->resource
        ->delete
        ->uri($orderUri)
        ->eager
        ->request();

        $this['ordered'] = true;

        // log
        $this['logs'] = $this->getLogs();

        return $this;
    }

    /**
     * Get logs
     *
     * @return array
     */
    private function getLogs()
    {
        $logs = [];
        $statusText = (new Code)->statusText;
        foreach ($this->resourceLogger as $resourceLog) {
            list($request, $response) = $resourceLog;
            $logs[] = [
            'request' => $request->toUriWithMethod(),
            'code' => "{$response->code} {$statusText[$response->code]}",
            'body' => (string) $response
            ];
        }

        return $logs;
    }
}
