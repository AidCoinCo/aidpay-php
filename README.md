# AIDPay for PHP

A PHP wrapper for [AIDPay](https://www.aidchain.co/aidpay) APIs

Official documentation on [https://apidoc.aidpay.io](https://apidoc.aidpay.io)

## Install

```
composer require aidcoinco/aidpay-php
```

## Generate API Key and Secret

Contact AidCoin to have your API Key and Secret [here](https://www.aidchain.co/aidpay).


## Usage

### Prepare requirements

```php
require __DIR__ . '/vendor/autoload.php';

use AidCoin\AidPay;
```

### Create client

```php
$aidPay = new AidPay('yourApiKey', 'yourApiSecret');
```

### Call APIs


#### getCharities

Description:
+ Returns the list of enabled charities.

Params:
+ array with limit (default 12) and offset (default 0) 

```php
$aidPay->getCharities(['limit' => 2, 'offset' => 0]);
```

result: 

```json
{
  "data": [
    {
      "id": 1,
      "name": "Friends Charity",
      "logo": "https://www.aidchain.io/image/charity/friends-charity.jpeg",
      "url": "https://www.aidchain.io/charity/friends-charity"
    },
    {
      "id": 2,
      "name": "Save Us Charity",
      "logo": "https://www.aidchain.io/image/charity/save-us-charity.jpeg",
      "url": "https://www.aidchain.io/charity/save-us-charity"
    }
  ],
  "count": 7,
  "pagination": {
    "page": 1,
    "pages": 4,
    "next": "/api/v1/aidpay/payments/charities?limit=2&offset=2",
    "prev": null
  }
}
```


#### getCurrencies

Description:
+ Returns the list of enabled currencies as a flat array with the associated DAI rate value.

```php
$aidPay->getCurrencies();
```

result: 

```json
[
  {
    "name": "Aidcoin",
    "code": "AID",
    "daiRate": "0.0459845847"
  },
  {
    "name": "Attention Token",
    "code": "BAT",
    "daiRate": "0.1553115365"
  },
  {
    "name": "Blackcoin",
    "code": "BC",
    "daiRate": "0.0639980109"
  },
  {
    "name": "Bitcoin",
    "code": "BTC",
    "daiRate": "6153.6548980605"
  },
  {
    "name": "Dash",
    "code": "DASH",
    "daiRate": "159.9950888861"
  },
  {
    "name": "Decred",
    "code": "DCR",
    "daiRate": "37.8817317255"
  },
  {
    "name": "Dogecoin",
    "code": "DOGE",
    "daiRate": "0.0049602187"
  },
  {
    "name": "Enjincoin",
    "code": "ENJ",
    "daiRate": "0.0461524117"
  },
  {
    "name": "Essentia",
    "code": "ESS",
    "daiRate": "0.0021755345"
  },
  {
    "name": "Ethereum",
    "code": "ETH",
    "daiRate": "196.2888531824"
  },
  {
    "name": "Gamecredits",
    "code": "GAME",
    "daiRate": "0.1615949776"
  },
  {
    "name": "Gridcoin",
    "code": "GRC",
    "daiRate": "0.0106458229"
  },
  {
    "name": "Groestlcoin",
    "code": "GRS",
    "daiRate": "0.5194300099"
  },
  {
    "name": "Litecoin",
    "code": "LTC",
    "daiRate": "50.6322725012"
  },
  {
    "name": "Pivx",
    "code": "PIVX",
    "daiRate": "1.1255034808"
  },
  {
    "name": "Power Ledger",
    "code": "POWR",
    "daiRate": "0.1737176777"
  },
  {
    "name": "Peercoin",
    "code": "PPC",
    "daiRate": "0.8839109895"
  },
  {
    "name": "Augur",
    "code": "REP",
    "daiRate": "11.7099129786"
  },
  {
    "name": "Syscoin",
    "code": "SYS",
    "daiRate": "0.0851665837"
  },
  {
    "name": "BLOCKv",
    "code": "VEE",
    "daiRate": "0.0089843361"
  },
  {
    "name": "Vertcoin",
    "code": "VTC",
    "daiRate": "0.6460106911"
  },
  {
    "name": "Zcash",
    "code": "ZEC",
    "daiRate": "110.0055656389"
  },
  {
    "name": "0x",
    "code": "ZRX",
    "daiRate": "0.6442757334"
  }
]
```


#### getLimits

Description:
+ Returns the min and max amounts of tokens to be exchanged both in DAI and in selected currency.

Params:
+ fromCurrency: the currency from which to start the transaction

```php
$aidPay->getLimits('BTC');
```

result: 

```json
{
  "DAI": {
    "min": "4.5",
    "max": "6299.05278899"
  },
  "BTC": {
    "min": "0.000731227272727",
    "max": "1.02356426481"
  },
  "USD": {
    "min": "0.226368",
    "max": "316.867551497"
  },
  "EUR": {
    "min": "0.1956285",
    "max": "273.838721896"
  },
  "GBP": {
    "min": "0.17145",
    "max": "239.993911261"
  }
}
```


#### createDonation

ONLY FOR NO-PROFIT ACCOUNTS

Description:
+ Create a donation.

Params:
+ orderId: a reference for the customer (i.e. his progressive order id). Will be sent for reference in notifications
+ fromCurrency: the currency from which to start the transaction
+ invoicedAmount: the amount to convert (in "fromCurrency")
+ email: your customer notification email
+ itemId: the item id of the charity to send the funds to
+ refundAddress: an optional address compatible with "fromCurrency" for receiving refunds in case of problems with the blockchain
+ return: the return URL that will be used to redirect your buyers back to your site 

```php
$aidPay->createDonation(
    'O-12345',
    'BTC',
    '0.1',
    'example@aidcoin.co',
    '1',
    '1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG',
    'https://your.client/return/url'
);
```

result: 

```json
{
  "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
  "orderId": "O-12345",
  "status": "WAITING_FOR_DEPOSIT",
  "email": "example@aidcoin.co",
  "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
  "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
  "exchangeRate": "6138.0122760247",
  "fromCurrency": "BTC",
  "toCurrency": "DAI",
  "invoicedAmount": "0.1",
  "orderedAmount": "612.3012276",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-10-11T11:56:57+02:00",
  "expireDate": "2018-10-11T12:16:56+02:00",
  "chargedFee": "1.5",
  "orderLink": "https://www.aidchain.co/aidpay/payment/aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee?return=https%3A//your.client/return/url"
}
```

The `invoicedAmount` will need to be sent to the `depositAddress` (by your users or through your system) within 20 minutes.   

If you want to use the AidPay interface redirect your users to `orderLink`.


#### createOrder

ONLY FOR MERCHANT ACCOUNTS

Description:
+ Create an order.

Params:
+ orderId: a reference for the customer (i.e. his progressive order id). Will be sent for reference in notifications
+ fromCurrency: the currency from which to start the transaction
+ fromFiat: the FIAT currency from which to start the conversion
+ fiatAmount: the amount to convert (in "fromFiat")
+ email: your customer notification email
+ refundAddress: an optional address compatible with "fromCurrency" for receiving refunds in case of problems with the blockchain
+ return: the return URL that will be used to redirect your buyers back to your site 

```php
$aidPay->createOrder(
    'O-12345',
    'BTC',
    'USD',
    '1000',
    'example@aidcoin.co',
    '1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG',
    'https://your.client/return/url'
);
```

result: 

```json
{
  "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
  "orderId": "O-12345",
  "status": "WAITING_FOR_DEPOSIT",
  "email": "example@aidcoin.co",
  "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
  "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
  "exchangeRate": "6197.5710529613",
  "fromCurrency": "BTC",
  "toCurrency": "DAI",
  "invoicedAmount": "0.163838",
  "orderedAmount": "1000.3971577",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-10-11T11:56:57+02:00",
  "expireDate": "2018-10-11T12:16:56+02:00",
  "chargedFee": "1.5",
  "orderLink": "https://www.aidchain.co/aidpay/payment/aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee?return=https%3A//your.client/return/url"
}
```

The `invoicedAmount` will need to be sent to the `depositAddress` (by your users or through your system) within 20 minutes.   

If you want to use the AidPay interface redirect your users to `orderLink`.


#### getStatus

Description:
+ Returns the status of the payment for a given uuid.

Params:
+ uuid: the unique id of the payment to search for

Notes: status could be ['WAITING_FOR_DEPOSIT','DEPOSIT_RECEIVED','DEPOSIT_CONFIRMED','EXECUTED','REFUNDED','CANCELED','EXPIRED']

```php
$aidPay->getStatus('aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee');
```

result: 

```json
{
  "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
  "orderId": "O-12345",
  "status": "WAITING_FOR_DEPOSIT",
  "email": "example@aidcoin.co",
  "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
  "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
  "exchangeRate": "64625.850340136300000000",
  "fromCurrency": "BTC",
  "toCurrency": "DAI",
  "invoicedAmount": "0.1",
  "orderedAmount": "616.97941526",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-10-11T11:56:57+02:00",
  "expireDate": "2018-10-11T12:16:56+02:00",
  "chargedFee": "1.5"
}
```


#### getOrders

Description:
+ Returns the customer's order list.

Params:
+ array with limit (default 12), offset (default 0) and an optional filters['status'] 

Notes: status could be ['WAITING_FOR_DEPOSIT','DEPOSIT_RECEIVED','DEPOSIT_CONFIRMED','EXECUTED','REFUNDED','CANCELED','EXPIRED']

```php
$aidPay->getOrders(['limit' => 2, 'offset' => 0, 'filters' => ['status' => 'WAITING_FOR_DEPOSIT']]);
```

result: 

```json
{
  "data": [
    {
      "uuid": "ffffffff-gggg-hhhh-iiii-llllllllllll",
      "orderId": "O-67890",
      "status": "WAITING_FOR_DEPOSIT",
      "email": "example@aidcoin.co",
      "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
      "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
      "exchangeRate": "6138.0122760247",
      "fromCurrency": "BTC",
      "toCurrency": "DAI",
      "invoicedAmount": "0.1",
      "orderedAmount": "612.3012276",
      "hash": null,
      "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
      "createdAt": "2018-10-11T11:56:57+02:00",
      "expireDate": "2018-10-11T12:16:56+02:00",
      "chargedFee": "1.5"
    },
    {
      "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
      "orderId": "O-12345",
      "status": "WAITING_FOR_DEPOSIT",
      "email": "example@aidcoin.co",
      "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
      "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
      "exchangeRate": "6138.0122760247",
      "fromCurrency": "BTC",
      "toCurrency": "DAI",
      "invoicedAmount": "0.1",
      "orderedAmount": "612.3012276",
      "hash": null,
      "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
      "createdAt": "2018-10-11T11:56:57+02:00",
      "expireDate": "2018-10-11T12:16:56+02:00",
      "chargedFee": "1.5"
    }
  ],
  "count": 23,
  "pagination": {
    "page": 1,
    "pages": 12,
    "next": "/api/v1/aidpay/payments/charities?limit=2&offset=2",
    "prev": null
  }
}
```


#### deletePayment

Description:
+ Delete a payment for a given uuid.

Params:
+ uuid: the unique id of the payment to search for

```php
$aidPay->cancelPayment('aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee');
```

result: 

```json
{
  "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
  "orderId": "O-12345",
  "status": "CANCELED",
  "email": "example@aidcoin.co",
  "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
  "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
  "exchangeRate": "6138.0122760247",
  "fromCurrency": "BTC",
  "toCurrency": "DAI",
  "invoicedAmount": "0.1",
  "orderedAmount": "612.3012276",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-10-11T11:56:57+02:00",
  "expireDate": "2018-10-11T12:16:56+02:00",
  "chargedFee": "1.5"
}
```


### Receive Call

When your payment has been `EXECUTED` you will receive a POST to the `return_url` provided during the setup process.

You should sign the call BODY with your API Secret and then check that it matches our provided sign in HEADERS.

Notes: this is a Server To Server http call.

```bash
curl -X POST \
  https://your-provided-return-url \
  -H 'Content-Type: application/json' \
  -H 'sign: <signed message from body below>' \
  -d '{
        "uuid": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
        "orderId": "O-12345",
        "status": "EXECUTED",
        "email": "example@aidcoin.co",
        "depositAddress": "1HfL94JWjmmjroyAHTDhRQqUwZ7PR4JoUZ",
        "destination": "0x4Aa0f67D9A0666b9Dd0Ee6d397334903AE337e1E",
        "exchangeRate": "6138.0122760247",
        "fromCurrency": "BTC",
        "toCurrency": "DAI",
        "invoicedAmount": "0.1",
        "orderedAmount": "612.3012276",
        "hash": "0xc28b0..........ac11",
        "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
        "createdAt": "2018-10-11T11:56:57+02:00",
        "expireDate": "2018-10-11T12:16:56+02:00",
        "chargedFee": "1.5"
      }'
```

```php
$headers = getallheaders();
$body = json_decode(file_get_contents('php://input'), true);

if ($aidPay->isValidSignature($headers['sign'], $body)) {
    // Do stuffs (i.e. set your payment as paid). Your payment has been executed.
} else {
    // Discard. This is not a valid call.
}
```
