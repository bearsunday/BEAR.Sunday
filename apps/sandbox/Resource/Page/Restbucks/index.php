<?php
namespace sandbox\Resource\Page\Restbucks;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;

/**
 * Restbucks order
 *
 */
class index extends Page
{
    use ResourceInject;

    public $body = [
        'ordered' => false
    ];

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
     * @return \sandbox\Resource\Page\Restbucks\Index
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
        $paymentUri = $updateResponse->links['payment']['href'];
        $paymentResponse = $this
        ->resource
        ->put
        ->uri($paymentUri)
        ->addQuery([
            'id' => $orderId,
            'card_no' => '00001234',
            'expires' => '010820',
            'name' => 'sunday',
            'amount' =>4
        ])
        ->eager
        ->request();

        // Story 4: As a barista, I want to see the list of drinks that I need to make, so that I can serve my customers.
        // （店）お客さんに提供するために注文をみて、注文を"準備中"に変更する

        // get one order
        $statusResponse = $this
        ->resource
        ->get
        ->uri('app://self/restbucks/orders')
        ->eager
        ->request();
        $order = $statusResponse->body['order'][0];

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

        return $this;
    }
}
