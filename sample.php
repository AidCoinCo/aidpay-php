<?php
require __DIR__ . '/vendor/autoload.php';

use AidCoin\AidPay;

try {
    $aidPay = new AidPay('yourApiKey', 'yourApiSecret');

    $result = $aidPay->getCurrencies();

    echo json_encode($result);

} catch (\Exception $e) {
    echo json_encode(
        [
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ]
    );
}
