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
+ Returns the list of enabled currencies as a flat array with the associated AID rate value.

```php
$aidPay->getCurrencies();
```

result: 

```json
[
  {
    "name": "Attention Token",
    "code": "BAT",
    "aid_rate": "2.4326873385"
  },
  {
    "name": "Blackcoin",
    "code": "BC",
    "aid_rate": "1.2065245478"
  },
  {
    "name": "Bitcoin",
    "code": "BTC",
    "aid_rate": "61369.5090439273"
  },
  {
    "name": "Dai Stablecoin",
    "code": "DAI",
    "aid_rate": "7.444121447"
  },
  {
    "name": "Dash",
    "code": "DASH",
    "aid_rate": "1842.9453811369"
  },
  {
    "name": "Decred",
    "code": "DCR",
    "aid_rate": "487.2174418604"
  },
  {
    "name": "Digixdao",
    "code": "DGD",
    "aid_rate": "707.5329457364"
  },
  {
    "name": "Dogecoin",
    "code": "DOGE",
    "aid_rate": "0.0257751937"
  },
  {
    "name": "Essentia",
    "code": "ESS",
    "aid_rate": "0.0552325581"
  },
  {
    "name": "Ethereum",
    "code": "ETH",
    "aid_rate": "3557.2835917926"
  },
  {
    "name": "Flyp.me Token",
    "code": "FYP",
    "aid_rate": "0.7364341085"
  },
  {
    "name": "Gamecredits",
    "code": "GAME",
    "aid_rate": "3.5385658914"
  },
  {
    "name": "Gridcoin",
    "code": "GRC",
    "aid_rate": "0.2424095607"
  },
  {
    "name": "Groestlcoin",
    "code": "GRS",
    "aid_rate": "5.5158914728"
  },
  {
    "name": "Litecoin",
    "code": "LTC",
    "aid_rate": "647.1420865633"
  },
  {
    "name": "Pivx",
    "code": "PIVX",
    "aid_rate": "14.5648255813"
  },
  {
    "name": "Peercoin",
    "code": "PPC",
    "aid_rate": "8.5309754521"
  },
  {
    "name": "Augur",
    "code": "REP",
    "aid_rate": "226.276744186"
  },
  {
    "name": "Syscoin",
    "code": "SYS",
    "aid_rate": "1.2415051679"
  },
  {
    "name": "BLOCKv",
    "code": "VEE",
    "aid_rate": "0.1528100775"
  },
  {
    "name": "Vertcoin",
    "code": "VTC",
    "aid_rate": "10.0830103359"
  },
  {
    "name": "Zcash",
    "code": "ZEC",
    "aid_rate": "1669.2506459948"
  },
  {
    "name": "0x",
    "code": "ZRX",
    "aid_rate": "8.4763565891"
  }
]
```


#### getLimits

Description:
+ Returns the min and max amounts of tokens to be exchanged both in AID and in selected currency.

Params:
+ fromCurrency: the currency from which to start the transaction

```php
$aidPay->getLimits('BTC');
```

result: 

```json
{
  "AID": {
    "min": "9.0",
    "max": "26519.21353053"
  },
  "BTC": {
    "min": "0.000138789473684",
    "max": "0.408954187602"
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
  "exchangeRate": "64625.850340136300000000",
  "fromCurrency": "BTC",
  "toCurrency": "AID",
  "invoicedAmount": "0.100000000000000000",
  "orderedAmount": "6459.585034010000000000",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-07-26T14:44:28+02:00",
  "expireDate": "2018-07-26T15:04:26+02:00",
  "chargedFee": "3.000000000000000000",
  "orderLink": "https://local.aidchain.io/aidpay/payment/aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee?return=https%3A//your.client/return/url" // redirect your user here if you want to use the AidPay interface
}
```


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
    'EUR',
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
  "exchangeRate": "90090.090090090000000000",
  "fromCurrency": "BTC",
  "toCurrency": "AID",
  "invoicedAmount": "0.1737232",
  "orderedAmount": "15647.73811945",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-09-05T10:40:46+02:00",
  "expireDate": "2018-09-05T11:00:44+02:00",
  "chargedFee": "3.000000000000000000",
  "orderLink": "https://local.aidchain.io/aidpay/payment/aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee?return=https%3A//your.client/return/url" // redirect your user here if you want to use the AidPay interface
}
```


#### getStatus

Description:
+ Returns the status of the payment for a given uuid.

Params:
+ uuid: the unique id of the payment to search for

Note: status could be ['WAITING_FOR_DEPOSIT','DEPOSIT_RECEIVED','DEPOSIT_CONFIRMED','EXECUTED','REFUNDED','CANCELED','EXPIRED']

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
  "toCurrency": "AID",
  "invoicedAmount": "0.100000000000000000",
  "orderedAmount": "6459.585034010000000000",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-07-26T14:44:28+02:00",
  "expireDate": "2018-07-26T15:04:26+02:00",
  "chargedFee": "3.000000000000000000"
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
  "exchangeRate": "64625.850340136300000000",
  "fromCurrency": "BTC",
  "toCurrency": "AID",
  "invoicedAmount": "0.100000000000000000",
  "orderedAmount": "6459.585034010000000000",
  "hash": null,
  "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
  "createdAt": "2018-07-26T14:44:28+02:00",
  "expireDate": "2018-07-26T15:04:26+02:00",
  "chargedFee": "3.000000000000000000"
}
```


### Receive Call

When your payment will be EXECUTED you will receive a POST to your return url provided during the setup process.

You should sign the call BODY with your API Secret and then check that it matches our provided sign in HEADERS.


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
        "exchangeRate": "64625.850340136300000000",
        "fromCurrency": "BTC",
        "toCurrency": "AID",
        "invoicedAmount": "0.100000000000000000",
        "orderedAmount": "6459.585034010000000000",
        "hash": "0xc28b0..........ac11",
        "refundAddress": "1Nv92z71iinNVPncrDm4RPHyo17S9bEVPG",
        "createdAt": "2018-07-26T14:44:28+02:00",
        "expireDate": "2018-07-26T15:04:26+02:00",
        "chargedFee": "3.000000000000000000"
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
