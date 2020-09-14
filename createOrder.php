<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;

require __DIR__ . '/../../vendor/autoload.php';

$client = new Client();

$SHIPPING_API_URL = 'https://dev-online-gateway.ghn.vn';

$API_END_POINT = '/shiip/public-api/v2/shipping-order/create';

$url = $SHIPPING_API_URL . $API_END_POINT;

$token = 'a8959acb-f5e0-11ea-854a-465bc235df7b';

$shopId = 74838;

try {
    $headers = [
        'Token' => $token,
        'Content-Type' => 'application/json',
        'ShopId' => $shopId
    ];

    $json = '{
        "payment_type_id": 1,
        "note": "Test",
        "required_note": "KHONGCHOXEMHANG",
        "return_phone": "0368949601",
        "return_address": "39 NTT",
        "return_district_id": "1443",
        "return_ward_code": "20210",
        "client_order_code": "",
        "to_name": "Test",
        "to_phone": "0987654321",
        "to_address": "72 Thành Thái, Phường 14, Quận 10, Hồ Chí Minh, Vietnam",
        "to_ward_code": "20110",
        "to_district_id": "1442",
        "cod_amount": 200000,
        "content": "ABCDEF",
        "weight": 2000,
        "length": 15,
        "width": 15,
        "height": 15,
        "pick_station_id": 0,
        "deliver_station_id": 0,
        "insurance_value": 200000,
        "service_id": 0,
        "service_type_id":1,
        "items":
        [
            {
                "name":"quần dài",
                "code":"sip123",
                "quantity":1
            }
        ]
        }';
    $response = $client->request(
        'POST',
        $url,
        [
            'json' => json_decode($json),
            'headers' => $headers,
        ],
    );


    $data = json_decode($response->getBody(), true);

    echo json_encode($data);
} catch (ClientException $clientException) {

    echo json_encode([
        'err_type' => 'CLIENT ERROR',
        'msg' => $clientException->getTrace()
    ]);
} catch (ServerException $serverException) {

    echo json_encode([
        'err_type' => 'SERVER ERROR',
        'msg' => $serverException->getMessage()
    ]);
}
