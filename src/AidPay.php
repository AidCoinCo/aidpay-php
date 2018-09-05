<?php
/**
 * AIDPay PHP
 *
 * @link      https://github.com/aidcoinco/aidpay-php
 * @author    Vittorio Minacori (https://github.com/vittominacori)
 * @license   https://github.com/aidcoinco/aidpay-php/blob/master/LICENSE (MIT License)
 */
namespace AidCoin;

use Unirest;

/**
 * Class Market
 * @package AidPay
 */
class AidPay
{
    private static $endpoint = 'https://www.aidchain.co/api/v1/aidpay/payments/';
    private static $apiKey = '';
    private static $apiSecret = '';

    /**
     * AidPay constructor.
     * @param string $apiKey
     * @param string $apiSecret
     * @throws \Exception
     */
    public function __construct($apiKey, $apiSecret)
    {
        if (empty($apiKey) || empty($apiSecret)) {
            throw new \Exception('Invalid api key or secret');
        }
        self::$apiKey = $apiKey;
        self::$apiSecret = $apiSecret;

        Unirest\Request::verifyPeer(false);
    }

    // public methods

    /**
     * @param string $signature
     * @param array $arrayMessage
     * @return bool
     * @throws Unirest\Exception
     */
    public function isValidSignature($signature, $arrayMessage = []) {
        $message = Unirest\Request\Body::json($arrayMessage);
        return $signature === $this->signMessage($message);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function getCharities($parameters = [])
    {
        return $this->get('charities', $parameters);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getCurrencies()
    {
        return $this->get('currencies');
    }

    /**
     * @param string $fromCurrency
     * @return mixed
     * @throws \Exception
     */
    public function getLimits($fromCurrency)
    {
        return $this->get(strtoupper($fromCurrency) . '/limits');
    }

    /**
     * @param string $uuid
     * @return mixed
     * @throws \Exception
     */
    public function getStatus($uuid)
    {
        return $this->get($uuid);
    }

    /**
     * @param string $orderId
     * @param string $fromCurrency
     * @param float $amount
     * @param string $email
     * @param integer $itemId
     * @param string|null $refundAddress
     * @param string $itemType
     * @return mixed
     * @throws \Exception
     */
    public function createDonation(
        $orderId,
        $fromCurrency,
        $amount,
        $email,
        $itemId,
        $refundAddress = null,
        $itemType = 'charity'
    ) {
        $body = [
            'orderId' => $orderId,
            'fromCurrency' => $fromCurrency,
            'invoicedAmount' => $amount,
            'email' => $email,
            'itemId' => $itemId,
            'itemType' => $itemType,
            'refundAddress' => $refundAddress
        ];

        return $this->post('donation', $body);
    }

    /**
     * @param string $orderId
     * @param string $fromCurrency
     * @param string $fromFiat
     * @param float $fiatAmount
     * @param string $email
     * @param string|null $refundAddress
     * @return mixed
     * @throws \Exception
     */
    public function createOrder(
        $orderId,
        $fromCurrency,
        $fromFiat,
        $fiatAmount,
        $email,
        $refundAddress = null
    ) {
        $body = [
            'orderId' => $orderId,
            'fromCurrency' => $fromCurrency,
            'fromFiat' => $fromFiat,
            'fiatAmount' => $fiatAmount,
            'email' => $email,
            'refundAddress' => $refundAddress
        ];

        return $this->post('order', $body);
    }

    /**
     * @param string $uuid
     * @return mixed
     * @throws \Exception
     */
    public function cancelPayment($uuid)
    {
        $body = [
            'uuid' => $uuid
        ];

        return $this->post('cancel', $body);
    }

    // private methods

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    private function get($method, $parameters = [])
    {
        $message = '';

        $sign = $this->signMessage($message);
        $headers = [
            'api-key' => self::$apiKey,
            'sign' => $sign,
            'Content-Type' => 'application/json'
        ];
        $response = Unirest\Request::get(self::$endpoint . $method, $headers, $parameters);

        if ($response->code == 200) {
            return $response->body;
        } else {
            throw new \Exception($response->body->message, $response->code);
        }
    }

    /**
     * @param string $method
     * @param array $body
     * @return mixed
     * @throws \Exception
     */
    private function post($method, $body = [])
    {
        $message = Unirest\Request\Body::json($body);

        $sign = $this->signMessage($message);
        $headers = [
            'api-key' => self::$apiKey,
            'sign' => $sign,
            'Content-Type' => 'application/json'
        ];
        $response = Unirest\Request::post(self::$endpoint . $method, $headers, $message);

        if ($response->code == 200) {
            return $response->body;
        } else {
            throw new \Exception($response->body->message, $response->code);
        }
    }

    /**
     * Returns a keyed hash value using the HMAC method
     *
     * @param string $message
     * @return string
     */
    private function signMessage($message) {
        return hash_hmac('sha512', $message, self::$apiSecret);
    }
}
